import '../sass/theme.scss'; // load in styles

const weba = {};
window.$ = window.jQuery;
const $document = $(document);

/* ---------------------------
  Main Menu
--------------------------- */
// Each object contains an init function which initalizes all the functions within the object.
// This means that each function can have the logic within it and functions can be turned on and
// off within the init which makes for customization for future client work

weba.mainMenu = {
    init() {
        const $hamburgerMenuBtn = $('#js-open-nav');
        const $navMenu = $('#nav-menu-container');
        const $menuLinks = $navMenu.find('a');
        const $allLinks = $('a');
        const $siteBrandingLink = $('.site-branding-link--header');

        $hamburgerMenuBtn.on('click', () => {
            const isOpen = $hamburgerMenuBtn.attr('aria-expanded') === 'true';
            if (isOpen) {
                // Close the menu
                $navMenu.attr('aria-hidden', 'true').removeClass('visible');
                $hamburgerMenuBtn.attr('aria-expanded', 'false');
                $('body').removeClass('mobile__menu--open');
                $menuLinks.attr('tabindex', '-1');
            } else {
                // Open the menu
                $navMenu.attr('aria-hidden', 'false').addClass('visible');
                $hamburgerMenuBtn.attr('aria-expanded', 'true');
                $('body').addClass('mobile__menu--open');
                $menuLinks.attr('tabindex', '0');
            }
        });
        $allLinks.on('keydown', (e) => {
            // Check if Tab key is pressed and the hamburger menu is expanded
            if (e.key === 'Tab' && $hamburgerMenuBtn.attr('aria-expanded') === 'true') {
                e.preventDefault();

                // Check if Shift key is pressed
                const isShiftPressed = e.shiftKey;

                // Create an array of focusable elements
                const focusableElements = [
                    $siteBrandingLink[0], // Site logo
                    $hamburgerMenuBtn[0], // Hamburger Menu
                ].concat($menuLinks.toArray()); // Menu Links

                // Get the index of the currently focused element
                const currentIndex = focusableElements.indexOf(e.target);

                // Determine the direction based on Shift key
                const direction = isShiftPressed ? -1 : 1;

                // Calculate the index of the next focusable element
                const nextIndex = (currentIndex + direction
                    + focusableElements.length) % focusableElements.length;

                // Check if the next focusable element is defined and focus it
                if (focusableElements[nextIndex]) {
                    focusableElements[nextIndex].focus();
                }
            }
        });

        // Handle Enter key press on the hamburger menu button
        $hamburgerMenuBtn.on('keydown', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault(); // Prevent the default form submission behavior
                $hamburgerMenuBtn.trigger('click');
            }
        });
    },
    toggleOpen(element, className) {
        if (element.classList.contains(className)) {
            element.classList.remove(className);
        } else {
            element.classList.add(className);
        }
    },

    // Activate Submenu
    activateSubMenu(event) {
        const clickedElement = event.target;
        const thisDropdown = clickedElement.nextElementSibling;
        if (event.type === 'mousedown') {
            // alert('Mouse interaction!');
        } else if (event.type === 'touchstart') {
            event.preventDefault();
            if (clickedElement.classList.contains('dropdown-toggle--toggled')) {
                if (clickedElement.getAttribute('href')) {
                    window.location.href = clickedElement.getAttribute('href');
                }
            }
        }
        weba.mainMenu.toggleOpen(clickedElement, 'dropdown-toggle--toggled');
        weba.mainMenu.toggleOpen(thisDropdown, 'dropdown-menu--open');
    },
    navbarToggleHandler(event) {
        event.preventDefault();
        const toggle = $(this);
        const body = $document.find('body');
        const headerNavigation = $document.find('.primary__navigation');
        if (!body.hasClass('mobile__menu--open')) {
            // Open the menu
            body.addClass('mobile__menu--open');
            toggle.addClass('menu__trigger--close');
            headerNavigation.addClass('open');
        } else {
            // Close the menu
            body.removeClass('mobile__menu--open');
            toggle.removeClass('menu__trigger--close');
            headerNavigation.removeClass('open');
        }
    },
    // Handle Mobile Menu Functionality
    expandMobileMenu() {
        $document.find('.header__navbar--toggle-button').on('click', weba.mainMenu.navbarToggleHandler);
        $('.menu-item-has-children.dropdown').each(function dropdownHandler() {
            // $(this).find('.dropdown-toggle').on('click', weba.mainMenu.activateSubMenu);
            $(this).find('.dropdown-toggle').on('mousedown touchstart', weba.mainMenu.activateSubMenu);
        });
    },

}; // weba.mainMenu

/* ----------------------------------------
  Handler Functions - Process the clicks and trigger things.
------------------------------------------ */
weba.handlers = {
    webassemblerHashLinkHandler(e) {
        // Check if the event was triggered by a mouse click or keyboard interaction.
        if (e.type === 'click' || (e.type === 'keydown' && (e.key === 'Enter' || e.key === ' '))) {
            e.preventDefault();

            // Get the target element by its ID
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);

            // Calculate the offset, considering the header height
            const scrollOffset = 72; // Adjust this value based on your header height

            // Scroll smoothly to the target element with the offset
            window.scrollTo({
                top: targetElement.offsetTop - scrollOffset,
                behavior: 'smooth',
            });

            // Set focus on the target element after a short delay
            const scrollHandler = () => {
                if (window.scrollY === targetElement.offsetTop - scrollOffset) {
                    targetElement.setAttribute('tabindex', '-1');
                    targetElement.focus();
                    window.removeEventListener('scroll', scrollHandler); // Remove the event listener after handling focus
                }
            };

            window.addEventListener('scroll', scrollHandler);
        }
    },
}; // weba.handlers

/*-------------------------------------------
  Flexible Content - Interactive Blocks
-------------------------------------------- */
weba.theme = {
    init() {
        weba.theme.initScrollToTop();
    },
    initScrollToTop() {
        // document.getElementById('scroll-top').addEventListener('click', weba.theme.scrollToTop);
    },
};

// Init when page ready
$(window).on('DOMContentLoaded', () => {
    weba.mainMenu.init();
    weba.theme.init();
});
