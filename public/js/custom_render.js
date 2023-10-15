var CustomDatatableRenders = {
    fitTextHTML: function(text) {
        return '<span class="fit-text">' + text + '</span>';
    },
    fitTextInit: function () {
        $('span.fit-text').dotdotdot({
            /* The text to add as ellipsis. */
            ellipsis   : '...',
            /* How to cut off the text/html: 'word'/'letter'/'children' */
            wrap      : 'letter',
            /* Wrap-option fallback to 'letter' for long words */
            fallbackToLetter: true,
            /* jQuery-selector for the element to keep and put after the ellipsis. */
            after     : null,
            /* Whether to update the ellipsis: true/'window' */
            watch     : "window",
            /* Optionally set a max-height, can be a number or function.
             If null, the height will be measured. */
            height    : 25,
            /* Deviation for the height-option. */
            tolerance  : 0,
            /* Callback function that is fired after the ellipsis is added,
             receives two parameters: isTruncated(boolean), orgContent(string). */
            callback   : function( isTruncated, orgContent ) {
                if (isTruncated) {
                    $(this).attr('title', orgContent.text());
                } else {
                    $(this).removeAttr('title');
                }
            },
            lastCharacter  : {
                /* Remove these characters from the end of the truncated text. */
                remove    : [ ' ', ',', ';', '.', '!', '?' ],
                /* Don't add an ellipsis if this array contains
                 the last character of the truncated text. */
                noEllipsis : []
            }
        });
    },
    datetimeHTML: function (datetime) {
        return '<span>' + datetime + '</span>';
    }
};