<template>
    <ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>
</template>

<script>
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
    import CKEditor from '@ckeditor/ckeditor5-vue';

    export default {
        components: {
            // Use the <ckeditor> component in this view.
            ckeditor: CKEditor.component
        },
        mounted() {
            document.getElementById('full-page-loader').style.display = 'none';
        },
        data() {
            return {
                editor: ClassicEditor,
                editorData: '<p>Content of the editor.</p>',
                editorConfig: {
                    // The configuration of the editor.
                }
            };
        }
    }
</script>
