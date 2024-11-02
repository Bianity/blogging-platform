import _ from "lodash";
window._ = _;

import axios from "axios";
window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
import {
    Livewire,
    Alpine,
} from "../../vendor/livewire/livewire/dist/livewire.esm";
import collapse from "@alpinejs/collapse";
import EditorJS from "@editorjs/editorjs";
import ImageTool from "@editorjs/image";
import Header from "@editorjs/header";
import List from "@editorjs/list";
import Paragraph from "@editorjs/paragraph";
import Underline from "@editorjs/underline";
import InlineCode from "@editorjs/inline-code";
import Quote from "@editorjs/quote";
import Embed from "@editorjs/embed";
import Marker from "@editorjs/marker";
import Delimiter from "@editorjs/delimiter";

window.EditorJS = EditorJS;
window.ImageTool = ImageTool;
window.Header = Header;
window.List = List;
window.Paragraph = Paragraph;
window.Underline = Underline;
window.InlineCode = InlineCode;
window.Quote = Quote;
window.Embed = Embed;
window.Marker = Marker;
window.Delimiter = Delimiter;

Alpine.plugin(collapse);
window.Alpine = Alpine;

Livewire.start();
