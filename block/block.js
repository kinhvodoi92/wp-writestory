(function (blocks, element, blockEditor) {
    var useBlockProps = blockEditor.useBlockProps;

    var blockStyle = {
        backgroundColor: '#fff',
        padding: '20px',
        border: 'red 10px',
    };

    blocks.registerBlockType('writestory-plugin/answer-block', {
        title: "Write a story",
        edit: ({questions}) => {
            return element.createElement("p", useBlockProps.save( { style: blockStyle } ), questions);
        },
        // save: ({questions}) => {
        //     return element.createElement("p", useBlockProps.save( { style: blockStyle } ), ...questions);
        // },
    })
}(window.wp.blocks, window.wp.element, window.wp.blockEditor));