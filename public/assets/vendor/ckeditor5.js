import {
    ClassicEditor,
    AccessibilityHelp,
    Autosave,
    Bold,
    Essentials,
    Italic,
    Mention,
    Paragraph,
    SelectAll,
    Undo
} from 'ckeditor5';

const editorConfig = {
    toolbar: {
        items: ['undo', 'redo', '|', 'selectAll', '|', 'bold', 'italic', '|', 'accessibilityHelp'],
        shouldNotGroupWhenFull: false
    },
    placeholder: 'Type or paste your content here!',
    plugins: [AccessibilityHelp, Autosave, Bold, Essentials, Italic, Mention, Paragraph, SelectAll, Undo],
    mention: {
        feeds: [
            {
                marker: '@',
                feed: [
                    /* See: https://ckeditor.com/docs/ckeditor5/latest/features/mentions.html */
                ]
            }
        ]
    },
    initialData: initialPostEditorData
};


ClassicEditor
    .create( document.querySelector( '#editor' ), editorConfig )
    .then( newEditor => {
        editor = newEditor;
    } )
    .catch( error => {
        console.error( error );
    } );
