wp.customize('colour_site_accent', function(value) {
    value.bind(function(newval) {
        document.documentElement.style
            .setProperty('--qb-colour-accent', newval);
    });
});

wp.customize('colour_site_accent_font', function(value) {
    value.bind(function(newval) {
        document.documentElement.style
            .setProperty('--qb-colour-accent-font', newval);
    });
});

wp.customize('colour_header_font', function(value) {
    value.bind(function(newval) {
        document.documentElement.style
            .setProperty('--qb-colour-header-font', newval);
    });
});

wp.customize('colour_header_bg', function(value) {
    value.bind(function(newval) {
        document.documentElement.style
            .setProperty('--qb-colour-header-bg', newval);
    });
});

wp.customize('colour_header_bg_hover', function(value) {
    value.bind(function(newval) {
        document.documentElement.style
            .setProperty('--qb-colour-header-bg-hover', newval);
    });
});

wp.customize('colour_content_meta_font', function(value) {
    value.bind(function(newval) {
        document.documentElement.style
            .setProperty('--qb-colour-content-meta-font', newval);
    });
});

wp.customize('colour_content_meta_bg', function(value) {
    value.bind(function(newval) {
        document.documentElement.style
            .setProperty('--qb-colour-content-meta-bg', newval);
    });
});

wp.customize('colour_footer_font', function(value) {
    value.bind(function(newval) {
        document.documentElement.style
            .setProperty('--qb-colour-footer-font', newval);
    });
});

wp.customize('colour_footer_bg', function(value) {
    value.bind(function(newval) {
        document.documentElement.style
            .setProperty('--qb-colour-footer-bg', newval);
    });
});
