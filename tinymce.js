(function ($) {

    tinymce.PluginManager.add('ng_sb_button', function (editor, url) {
        editor.addButton('ng_sb_button', {
            text: 'Breaks',
            icon: false,
            type: 'menubutton',
            menu: [
                {
                    text: 'br',
                    onclick: function() {
                        editor.insertContent('[br]');
                    }
                },
                {
                    text: 'Clear Left',
                    onclick: function() {
                        editor.insertContent('[clearleft]');
                    }
                },
                {
                    text: 'Clear Both',
                    onclick: function() {
                        editor.insertContent('[clearboth]');
                    }
                },
                {
                    text: 'Clear Right',
                    onclick: function() {
                        editor.insertContent('[clearright]');
                    }
                },
                {
                    text: 'hr',
                    onclick: function () {
                        editor.windowManager.open( {
                            title: 'hr',
                            body: [
                                {
                                    type: 'textbox',
                                    name: 'hrSize',
                                    label: 'Size of the hr (in pixels). Enter a number.',
                                    value: '1'
                                },
                                {
                                    type: 'textbox',
                                    name: 'hrColor',
                                    label: 'Color of the hr. Enter a color or hex value.',
                                    value: 'black'
                                }
                            ],
                            onsubmit: function( e ) {
                                editor.insertContent( '[hr size="' + e.data.hrSize + '" color="' + e.data.hrColor + '"]');
                            }
                        });
                    }
                },
                {
                    text: 'Space',
                    onclick: function () {
                        editor.windowManager.open( {
                            title: 'Space',
                            body: [
                                {
                                    type: 'textbox',
                                    name: 'spacerSize',
                                    label: 'Size of the space (in pixels). Enter a number.',
                                    value: '1'
                                }
                            ],
                            onsubmit: function( e ) {
                                editor.insertContent( '[space size="' + e.data.spacerSize + '"]');
                            }
                        });
                    }
                }
            ]
        });
    });

})(jQuery);