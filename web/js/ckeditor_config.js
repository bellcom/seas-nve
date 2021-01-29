/**
 * @file Custom CKEditor config
 */

CKEDITOR.editorConfig = function( config ) {
    config.format_h1_text = { name: 'Text H1', element: 'div', attributes: { 'class': 'h1' } };
    config.format_h2_text = { name: 'Text H2', element: 'div', attributes: { 'class': 'h2' } };
    config.format_h3_text = { name: 'Text H3', element: 'div', attributes: { 'class': 'h3' } };
    config.format_h4_text = { name: 'Text H4', element: 'div', attributes: { 'class': 'h4' } };
    config.format_h5_text = { name: 'Text H5', element: 'div', attributes: { 'class': 'h5' } };
    config.format_h6_text = { name: 'Text H6', element: 'div', attributes: { 'class': 'h6' } };
    config.format_tags = 'p;h1;h1_text;h2;h2_text;h3;h3_text;h4;h4_text;h5;h5_text;h6;h6_text;pre;address;div';
};
