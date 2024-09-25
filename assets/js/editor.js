wp.domReady( () => {
	wp.blocks.unregisterBlockStyle( 'core/button', 'default' );
	wp.blocks.unregisterBlockStyle( 'core/button', 'outline' );
	wp.blocks.unregisterBlockStyle( 'core/button', 'squared' );
	wp.blocks.unregisterBlockStyle( 'core/button', 'fill' );

	// Remove the alignment option
	wp.blocks.unregisterBlockStyle( 'core/heading', 'align-left' );
	wp.blocks.unregisterBlockStyle( 'core/heading', 'text-align' );

	wp.blocks.unregisterBlockStyle( 'core/separator', 'default' );
	wp.blocks.unregisterBlockStyle( 'core/separator', 'wide' );
	wp.blocks.unregisterBlockStyle( 'core/separator', 'dots' );
	
	wp.blocks.unregisterBlockStyle( 'core/image', 'rounded' );
	wp.blocks.unregisterBlockStyle( 'core/image', 'default' );

    // // Filters
    // wp.hooks.addFilter(
    //     'blocks.registerBlockType',
    //     'webassembler/restrict-media-text-child-blocks',
    //     function( settings, name ) {
    //         if ( name != 'core/media-text') {
    //             return settings;
    //         }

    //         return {
    //             ...settings,
    //             attributes: {
    //                 ...settings.attributes,
    //                 allowedBlocks: {
    //                     type: "array",
    //                     default: [ 'core/paragraph', 'core/image' ],
    //                 },
    //             }
    //         }
    //     }
    // );
} );

// wp.hooks.addFilter(
//     'blocks.registerBlockType',
//     'example/filter-options',
//     ( settings, name ) => {
//         if( 'core/group' === name ) {
//             return lodash.assign( {}, settings, {
//                 supports: lodash.assign( {}, settings.supports, {
//                     align: false, 
//                 } ),
//             } );
//         }
//         if( 'core/paragraph' === name ) {
//             return lodash.assign( {}, settings, {
//                 supports: lodash.assign( {}, settings.supports, {
//                     align: false, 
//                     alignText: false, 
//                 } ),
//             } );
//         }
//         // if( 'core/embed' === name ) {
//         //     return lodash.assign( {}, settings, {
//         //         supports: lodash.assign( {}, settings.supports, {
//         //             align: false,
//         //         } ),
//         //     } );
//         // }
//         return settings;
//     }
// );
