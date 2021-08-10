import { Controller } from 'stimulus';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
  static targets = ["textFld"];

  connect() {
    ClassicEditor
      .create(this.element, {
        toolbar: {
          items: [
            //      'heading', '|',
            // 'fontfamily', 'fontsize', '|',
            // 'alignment', '|',
            // 'fontColor', 'fontBackgroundColor', '|',
            'bold', 'italic', 
            //'strikethrough', 'underline', 'subscript', 'superscript', 
            '|',
            'link', '|',
            'outdent', 'indent', '|',
            'bulletedList', 'numberedList',
            //'todoList', 
            '|',
            //      'code', 'codeBlock', '|',
            //      'insertTable', '|',
            //      'uploadImage', 'blockQuote', '|',
            'undo', 'redo'
          ],
        },
        removePlugins: ['TableToolbar', 'Table', 'MediaEmbed',
          'Image', 'CKFinder', 'EasyImage', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload', 'CKFinderUploadAdapter', 'CloudServices',
          'Heading'],
        link: {
          decorators: {
            openInNewTab: {
              mode: 'manual',
              label: 'Open in a new tab',
              attributes: {
                target: '_blank',
                rel: 'noopener noreferrer'
              }
            }
          }
        }
      })
      .catch(error => {
        console.error(error);
      });

    // console.log(ClassicEditor.builtinPlugins.map(plugin => plugin.pluginName));

  }


}