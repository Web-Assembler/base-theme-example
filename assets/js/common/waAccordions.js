export default function waBuildAccordions(accordionItem, options = {}) {
    const accordionConfig = {
        header: '.accordion__header__wrapper',
        active: false,
        animate: 250,
        collapsible: true,
        heightStyle: 'content',
        ...options, // Spread user-provided options here to override defaults
    };
    $(accordionItem).accordion(accordionConfig);
}
