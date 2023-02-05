(function (blocks, element, blockEditor) {
    var el = element.createElement;
    var TextControl = wp.components.TextControl;
    var useBlockProps = blockEditor.useBlockProps;

    var blockStyle = {
        backgroundColor: '#fff',
        padding: '20px',
        border: 'red 10px',
    };

    // var message = select( 'core/blocks' ).getBlockType( 'survey-maker/survey' ).attributes.message;

    blocks.registerBlockType('writestory-plugin/answer-block', {
        title: "Write a story",
        edit: ({attributes, setAttributes}) => {
            return el("div",
                useBlockProps.save({ style: blockStyle }),
                el(
                    TextControl,
                    {
                        label: "Enter questions block ID",
                        type: 'number',
                        value: attributes.block_id,
                        onChange: (val) => setAttributes({ block_id: val }),
                    }
                ));
        },
        // save: ({ attributes }) => {
        //     return el("div",
        //         useBlockProps.save({ style: blockStyle }),
        //         attributes.message);
        // },
    })
}(window.wp.blocks, window.wp.element, window.wp.blockEditor));