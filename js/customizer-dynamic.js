wp.customize.bind('ready', () => {
    wp.customize.control('header_textcolor', (control) => {
        const toggleControl = (value) => {
            setting = 'blank' !== value;
            wp.customize.control('blogname').toggle(setting);
            wp.customize.control('blogdescription').toggle(setting);
        }

        toggleControl(control.setting.get());
        control.setting.bind(toggleControl);
    })

	wp.customize.control('site_show_dates', (control) => {
        const toggleControl = (value) => {
            wp.customize.control('site_start_year').toggle(value);
        }

        toggleControl(control.setting.get());
        control.setting.bind(toggleControl);
    });
});