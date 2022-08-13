wp.customize('header_textcolor', function(value) {
    value.bind(function(newval) {
        newval === 'blank' ? display = 'none' : display = 'block';

        document.querySelector('#logo-text').style
            .setProperty('display', display);
        }
    );
});

wp.customize('site_copyright', function(value) {
    value.bind( function(newval) {
        document.querySelector('#copyright-text').innerHTML = newval;
    });
});

wp.customize('site_show_dates', function(value) {
    value.bind( function(newval) {
        const element = document.querySelector('#copyright-year');
        newval ? element.style.display = 'inline' :
            element.style.display = 'none';
        
    });
});

wp.customize('site_start_year', function(value) {
    value.bind(function(newval) {
        const element = document.querySelector('#copyright-year');
        const year = new Date().getFullYear();

        newval >= year ? element.innerHTML = year :
            element.innerHTML = newval + ' - ' + year;
    });
});

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

wp.customize('media_post_thumb_bg', function(value) {
    value.bind(function(newval) {
        document.documentElement.style
            .setProperty('--qb-media-post-thumb-bg', newval);
    });
});