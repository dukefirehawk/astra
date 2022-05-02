import { setCustomize } from '../../../../utils/customize';
import { createURL, createNewPost, insertBlock } from '@wordpress/e2e-test-utils';
import { publishPost } from '../../../../utils/publish-post';
describe( 'Global button setting under the Customizer', () => {
	it( 'button border width should apply correctly', async () => {
		const borderWidth = {
			'theme-button-border-group-border-size': {
				top: 5,
				right: 5,
				bottom: 5,
				left: 5,
			},
		};
		await setCustomize( borderWidth );
		let ppStatus = false;
		while ( false === ppStatus ) {
			await createNewPost( {
				postType: 'post',
				title: 'buttonBorder',
			} );
			await insertBlock( 'Buttons' );
			await page.keyboard.type( 'Login' );
			ppStatus = await publishPost();
		}
		await page.goto( createURL( 'buttonBorder' ), {
			waitUntil: 'networkidle0',
		} );
		await page.waitForSelector( '#block-2 .wp-block-search__button, .wp-block-button .wp-block-button__link' );
		await expect( {
			selector: '#block-2 .wp-block-search__button, .wp-block-button .wp-block-button__link',
			property: 'border-top-width',
		} ).cssValueToBe( `${ borderWidth[ 'theme-button-border-group-border-size' ].top + 'px' }` );
		await expect( {
			selector: '#block-2 .wp-block-search__button, .wp-block-button .wp-block-button__link',
			property: 'border-right-width',
		} ).cssValueToBe( `${ borderWidth[ 'theme-button-border-group-border-size' ].right + 'px' }` );
		await expect( {
			selector: '#block-2 .wp-block-search__button, .wp-block-button .wp-block-button__link',
			property: 'border-bottom-width',
		} ).cssValueToBe( `${ borderWidth[ 'theme-button-border-group-border-size' ].bottom + 'px' }` );
		await expect( {
			selector: '#block-2 .wp-block-search__button, .wp-block-button .wp-block-button__link',
			property: 'border-left-width',
		} ).cssValueToBe( `${ borderWidth[ 'theme-button-border-group-border-size' ].left + 'px' }` );
	} );

	it( 'button border color should apply correctly', async () => {
		const borderColor = {
			'theme-button-border-group-border-color': 'rgb(4, 7, 11)',
		};
		await setCustomize( borderColor );
		await page.goto( createURL( 'buttonBorder' ), {
			waitUntil: 'networkidle0',
		} );
		await page.waitForSelector( '.wp-block-search__button, .wp-block-button .wp-block-button__link' );
		await expect( {
			selector: '.wp-block-search__button, .wp-block-button .wp-block-button__link',
			property: 'border-color',
		} ).cssValueToBe( `${ borderColor[ 'theme-button-border-group-border-color' ] }` );
	} );

	it( 'button border radius should apply correctly', async () => {
		const borderRadius = {
			'button-radius': '30',
		};
		await setCustomize( borderRadius );
		await page.goto( createURL( 'buttonBorder' ), {
			waitUntil: 'networkidle0',
		} );
		await page.waitForSelector( '.wp-block-button .wp-block-button__link, form[CLASS*="wp-block-search__"].wp-block-search .wp-block-search__inside-wrapper .wp-block-search__button' );
		await expect( {
			selector: '.wp-block-button .wp-block-button__link, form[CLASS*="wp-block-search__"].wp-block-search .wp-block-search__inside-wrapper .wp-block-search__button',
			property: 'border-radius',
		} ).cssValueToBe( `${ borderRadius[ 'button-radius' ] + 'px' }` );
	} );
} );
