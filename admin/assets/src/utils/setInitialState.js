import apiFetch from '@wordpress/api-fetch';

const setInitialState = ( store ) => {
	apiFetch( {
		path: '/astra/v1/admin/settings/',
	} ).then( ( data ) => {
		const initialState = {
			settingsSavedNotification: '',
			initialStateSetFlag : true,
			activeSettingsNavigationTab : 'global-settings',
			enableLoadFontsLocally : data.self_hosted_gfonts,
			enablePreloadLocalFonts : data.preload_local_fonts,
			useOldHeaderFooter: data.use_old_header_footer,
			useUpgradeNotices: data.use_upgrade_notices,
			blocksStatuses : data.pro_addons,
		};

		store.dispatch( {type: 'UPDATE_INITIAL_STATE', payload: initialState} );
	} );
};

export default setInitialState;
