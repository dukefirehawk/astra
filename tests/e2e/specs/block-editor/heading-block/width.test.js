import { insertBlock, createNewPost, clickBlockToolbarButton } from '@wordpress/e2e-test-utils';
describe( 'Heading in gutenberg editor', () => {
	it( 'assert wide width of the heading in the block editor', async () => {
		await createNewPost( { postType: 'post', title: 'Heading block - Width test case' } );
		await page.click( '[aria-label="Settings"]' );
		await insertBlock( 'Heading' );
		await page.keyboard.type( 'Heading block with wide width.' );

		//wide width for heading block
		await clickBlockToolbarButton( 'Align' );
		await page.waitForFunction( () =>
			document.activeElement.classList.contains( 'components-dropdown-menu__menu-item' ) );
		await page.click( '[aria-label="Align"] button:nth-child(1)' );
		await page.waitForSelector( '.wp-block-heading' );
		await expect( {
			selector: '.wp-block-heading',
			property: 'width',
		} ).cssValueToBe( `910px` );
	} );
	it( 'assert full width of the heading in the block editor', async () => {
		await createNewPost( { postType: 'post', title: 'Heading block - Width test case' } );
		await page.click( '[aria-label="Settings"]' );
		await insertBlock( 'Heading' );
		await page.keyboard.type( 'Heading block with full width.' );
		//full width for heading block
		await clickBlockToolbarButton( 'Align' );
		await page.waitForFunction( () =>
			document.activeElement.classList.contains( 'components-dropdown-menu__menu-item' ) );
		await page.click( '[aria-label="Align"] button:nth-child(2)' );
		await page.waitForSelector( '.wp-block-heading' );
		await expect( {
			selector: '.wp-block-heading',
			property: 'width',
		} ).cssValueToBe( `910px` );
	} );

	it( 'assert default width of the heading in the block editor', async () => {
		await createNewPost( { postType: 'post', title: 'Heading block - Width test case' } );
		await page.click( '[aria-label="Settings"]' );
		await insertBlock( 'Heading' );
		await page.keyboard.type( 'Heading block with default width.' );
		//default width for heading block
		await page.waitForSelector( '.wp-block-heading' );
		await expect( {
			selector: '.wp-block-heading',
			property: 'width',
		} ).cssValueToBe( `910px` );
	} );
} );
