<?php

namespace App\Livewire\Front\Story;

use App\Http\Traits\HasUploadWithEditorJs;
use App\Managers\EditorJS\BlocksManager;
use App\Models\Community;
use App\Models\Story;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mews\Purifier\Facades\Purifier;
use WireUi\Traits\Actions;

class Create extends Component
{
    use WithFileUploads;
    use HasUploadWithEditorJs;
    use Actions;

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

    public $featuredImage;

    public $audioFile;

    public $authorId;

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

    public function updatedFeaturedImage()
    {
        $this->validate();
    }

    public function updatedAudioFile()
    {
        $this->validate();
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
            $this->rules()
        );

        if ($validator->fails()) {
            $this->notification()->error(
                $title = __('Validation Error!'),
                $description = __('Check your story settings'),
            );
            $validator->validate();
        }

        $this->validate();

        foreach ($formData as $key => $value) {
            if ($key == 'tagsData') {
                $this->tagsData = collect(json_decode($value))->pluck('value')->toArray();
            }
            if ($key == 'metaKeywords') {
                $this->metaKeywords = collect(json_decode($value))->pluck('value')->implode(', ', $value);
            }
        }

        // Render EditorJS data to string HTML
        $data = json_encode($this->editorData);
        $blocks = new BlocksManager($data);
        $this->body = $blocks->renderHtml();

        // Get First Paragraph from EditorJS data and Render to html
        $summary = html_entity_decode($data);
        $summary = getFirstParagraph(strip_tags($summary));
        $this->summary = find_problem_word($summary);

        $story = Story::create([
            'user_id' => isset($this->authorId) ? $this->authorId : auth()->id(),
            'community_id' => $this->community,
            'title' => strip_tags(Purifier::clean($this->title)),
            'subtitle' => strip_tags(Purifier::clean($this->subTitle)),
            'summary' => $this->summary,
            'body_rendered' => $this->body,
            'body' => $data,
            'content_visibility' => $this->storyContentVisibility ? $this->storyContentVisibility : 'All',
            'comment_visibility' => $this->commentVisibility ? $this->commentVisibility : 'Allow',
        ]);

        $meta = $story->meta;
        $meta['meta_title'] = ! empty($this->metaTitle) ? $this->metaTitle : null;
        $meta['meta_description'] = ! empty($this->metaDescription) ? $this->metaDescription : null;
        $meta['meta_keywords'] = ! empty($this->metaKeywords) ? $this->metaKeywords : null;
        $meta['meta_canonical_url'] = ! empty($this->metaCanonicalUrl) ? $this->metaCanonicalUrl : null;
        $story->meta = $meta;
        $story->save();

        if ($this->featuredImage != null) {
            $story->addMedia($this->featuredImage->getRealPath())->withResponsiveImages()->toMediaCollection('featured-image');
        }

        if ($this->audioFile != null) {
            $story->addMedia($this->audioFile->getRealPath())->preservingOriginal()->toMediaCollection('story-audio');
        }

        $story->retag($this->tagsData);

        $this->notification()->success(
            $title = __('Your story has been saved!'),
            $description = $this->title,
        );

        $this->featuredImage = null;

        return redirect()->route('story.edit', ['story' => $story->id]);
    }

    public function render()
    {
        $communities = Community::select('name', 'id')->get();

        return view('livewire.front.story.create', [
            'communities' => $communities,
        ]);
    }
}
