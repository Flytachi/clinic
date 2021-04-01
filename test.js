import Pagination from '@ckeditor/ckeditor5-pagination/src/pagination';

DecoupledEditor
    .create( document.querySelector( '#editor' ), {
        plugins: [ Pagination, ],
        toolbar: [
            'previousPage',
            'nextPage',
            'pageNavigation', '|',
        ],
        pagination: {
            // A4
            pageWidth: '21cm',
            pageHeight: '29.7cm',

            pageMargins: {
                top: '20mm',
                bottom: '20mm',
                right: '12mm',
                left: '12mm'
            }
        },
        licenseKey: 'your-license-key'
    } )
    .then( editor => {
        const editorContainer = document.querySelector( '#editor-container' );
        const toolbarContainer = document.querySelector( '#toolbar-container' );

        toolbarContainer.appendChild( editor.ui.view.toolbar.element );
        editorContainer.appendChild( editor.ui.view.editable.element );

        editor.ui.update();
    } )
    .catch( err => {
        console.error( err );
    }
);