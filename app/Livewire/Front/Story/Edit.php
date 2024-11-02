<?php

namespace App\Livewire\Front\Story;

use App\Http\Traits\HasUploadWithEditorJs;
use App\Managers\EditorJS\BlocksManager;
use App\Models\Community;
use App\Models\Poll;
use App\Models\Story;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mews\Purifier\Facades\Purifier;
use WireUi\Traits\Actions;

class Edit extends Component
{
    use WithFileUploads;
    use HasUploadWithEditorJs;
    use Actions;

    public $story;

    public $story_id;

    public array $tagsData;

    public $metaTitle;

    public $metaDescription;

    public $metaKeywords;

    public $metaCanonicalUrl;

    public $title;

    public $subTitle;

    public $community;

    public $body;

    public $summary;

    public $storyContentVisibility;

    public $commentVisibility;

    public $editorData;

    public $savedData;

    public $featuredImage;

    public $featuredImageMedia;

    public $audioFile;

    public $audioFileMedia;

    public $schedulePublish;

    public bool $submitted = false;

    public $question;

    public $pollEnds;

    public $addPoll = false;

    public $authorId;

    public function mount($story, $value = [])
    {
        $this->story_id = $story->id;
        $this->title = $story->title;
        $this->authorId = $story->user_id;
        $this->community = $story->community_id;
        $this->subTitle = $story->subtitle;
        $this->commentVisibility = $story->comment_visibility;
        $this->storyContentVisibility = $story->content_visibility;
        if (isset($story->meta)) {
            $this->metaTitle = $story->meta['meta_title'];
            $this->metaDescription = $story->meta['meta_description'];
            $this->metaCanonicalUrl = $story->meta['meta_canonical_url'];

            // Converting String to an Array
            $arrMetaKeywords = explode(', ', $story->meta['meta_keywords']);
            $this->metaKeywords = $arrMetaKeywords;
        }

        if (isset($story->published_at)) {
            $this->schedulePublish = $story->published_at;
        }

        // Media featured Image
        $story->getMedia('featured-image')->isNotEmpty()
            ? $this->featuredImageMedia = $story->getMedia('featured-image')->first()->getUrl()
            : $this->featuredImage;

        // Media audio file
        $story->getMedia('story-audio')->isNotEmpty()
            ? $this->audioFileMedia = $story->getMedia('story-audio')->first()->getUrl()
            : $this->audioFile;

        $value = $story->body;
        if (is_string($value)) {
            $value = json_decode($value, true);
        }
        $this->editorData = $value;

        // Tags
        $this->tagsData = $story->tagArray;

        //Poll
        if (isset($story->poll)) {
            $this->question = $story->poll->question;
            $this->pollEnds = $story->poll->poll_ends;
        }
    }

    public function rules(): array
    {
        return [
            'featuredImage' => [
                'nullable',
                'sometimes',
                'image',
                'mimes:jpg,jpeg,png,gif',
                'max:5120',
                Rule::dimensions()->minWidth(1200)->minHeight(630)->maxWidth(3840)->maxHeight(2160),
            ],
            'audioFile' => [
                'nullable',
                'sometimes',
                'mimes:mp3',
                'min:512',
                'max:512000',
            ],
        ];
    }

    public function messages()
    {
        return [
            'featuredImage.dimensions' => __('The :attribute dimensions cannot be less than (:min_width px by width) - (:min_height px by height) and cannot be above (:max_width px by width) - (:max_height px by height)'),
        ];
    }

    public function updateAndSave($formData)
    {
        $validator = Validator::make(
            [
                'title' => $this->title,
                'subTitle' => $this->subTitle,
                'authorId' => $this->authorId,
                'community' => $this->community,
                'metaTitle' => $this->metaTitle,
                'metaDescription' => $this->metaDescription,
                'metaKeywords' => $this->metaKeywords,
                'metaCanonicalUrl' => $this->metaCanonicalUrl,
            ],
            [
                'title' => 'required|min:10|max:160',
                'subTitle' => 'nullable|string|max:250',
                'authorId' => 'nullable|integer|exists:users,id',
                'community' => 'nullable|integer|exists:communities,id',
                'metaTitle' => 'nullable|max:60',
                'metaDescription' => 'nullable|max:156',
                'metaKeywords' => 'nullable',
                'metaCanonicalUrl' => 'nullable|url',
            ],
            $this->rules(),
        );

        if ($validator->fails()) {
            $this->notification()->error(
                $title = __('Validation Error!'),
                $description = __('Check your story settings'),
            );
            $validator->validate();
        }

        $this->validate();

        // Check tags add, remove
        foreach ($formData as $key => $value) {
            if ($key == 'tagsData') {
                $this->tagsData = collect(json_decode($value))->pluck('value')->toArray();
            }
            if ($key == 'metaKeywords') {
                $this->metaKeywords = collect(json_decode($value))->pluck('value')->implode(', ', $value);
            }
        }

        // Decode and render html
        if (isset($this->savedData)) {
            $newEditorState = json_encode($this->savedData);
        }
        $blocks = new BlocksManager($newEditorState);
        $this->body = $blocks->renderHtml();

        // Get First Paragraph from EditorJS data and Render to html
        $summary = html_entity_decode($newEditorState);
        $summary = getFirstParagraph(strip_tags($summary));
        $this->summary = find_problem_word($summary);

        $publish = $this->schedulePublish ? $this->schedulePublish : now();

        if (! empty($newEditorState)) {
            $story = Story::findOrFail($this->story_id);

            $story->forceFill([
                'title' => strip_tags(Purifier::clean($this->title)),
                'user_id' => isset($this->authorId) ? $this->authorId : auth()->id(),
                'community_id' => $this->community,
                'subtitle' => strip_tags(Purifier::clean($this->subTitle)),
                'summary' => $this->summary,
                'body_rendered' => $this->body,
                'body' => $newEditorState,
                'content_visibility' => $this->storyContentVisibility,
                'comment_visibility' => $this->commentVisibility,
                'published_at' => $this->submitted ? $publish : null,
            ])->save();

            $story->update([
                'meta' => [
                    'meta_title' => ! empty($this->metaTitle) ? $this->metaTitle : null,
                    'meta_description' => ! empty($this->metaDescription) ? $this->metaDescription : null,
                    'meta_keywords' => ! empty($this->metaKeywords) ? $this->metaKeywords : null,
                    'meta_canonical_url' => ! empty($this->metaCanonicalUrl) ? $this->metaCanonicalUrl : null,
                ],
            ]);

            if ($this->featuredImage != null) {
                $story->addMedia($this->featuredImage->getRealPath())->withResponsiveImages()->toMediaCollection('featured-image');
            }

            if ($this->audioFile != null) {
                $story->addMedia($this->audioFile->getRealPath())->preservingOriginal()->toMediaCollection('story-audio');
            }

            $story->retag($this->tagsData);

            if ($this->submitted === false) {
                $this->notification()->success(
                    $title = __('Your story is saved as a draft!'),
                    $description = $this->title,
                );
            }

            if ($this->submitted === true && isset($this->story->published_at) === true && is_string($this->schedulePublish) === false) {
                $this->notification()->success(
                    $title = __('Story updated!'),
                    $description = $this->title,
                );
            }

            if ($this->submitted === true && is_string($this->schedulePublish) === true) {
                $this->notification()->success(
                    $title = __('Story published,').' '.$this->schedulePublish,
                    $description = $this->title,
                );
            }

            if ($this->submitted === true && isset($this->schedulePublish) === false) {
                $this->notification()->success(
                    $title = __('Story published now!'),
                    $description = $this->title,
                );
            }

            $this->featuredImage = null;
        }
    }

    public function deleteFeaturedImage()
    {
        $story = Story::findOrFail($this->story_id);
        $story->getMedia('featured-image')->first()->delete();

        $this->featuredImageMedia = null;
    }

    public function deleteAudioFile()
    {
        $story = Story::findOrFail($this->story_id);
        $story->getMedia('story-audio')->first()->delete();

        $this->audioFileMedia = null;
    }

    public function removePoll($id)
    {
        $poll = Poll::find($id);
        $poll->delete();

        $this->addPoll = true;
        $this->notification()->success(
            $title = __('The poll successfully was deleted!'),
        );
    }

    public function render()
    {
        $communities = Community::select('name', 'id')->get();

        return view('livewire.front.story.edit', [
            'communities' => $communities,
        ]);
    }
}
