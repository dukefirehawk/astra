/**
 * Astra's Live Search
 *
 * @package Astra
 * @since x.x.x
 */

( function() {

	function decodeHTMLEntities (string) {
		var doc = new DOMParser().parseFromString(string, 'text/html')
		return doc.documentElement.textContent
	}

	function getSearchResultPostMarkup(resultsData) {
		let processedHtml = '';

		Object.entries( resultsData ).map( ( [ postType, postsData ] ) => {
			processedHtml += `<label class="ast-search--posttype-heading"> ${postType}s </label>`;

			postsData.map((post) => {
				const searchPostTitle = decodeHTMLEntities(post.title.rendered);
				const defaultMediaDetails = {
					sizes: {
						thumbnail: {
							source_url: post.placeholder_image,
						},
					}
				}

				let _embedded = post._embedded;
				const sizes = ( _embedded['wp:featuredmedia']?.[0]?.media_details || defaultMediaDetails ).sizes || {}
				const imgHtml = ( _embedded['wp:featuredmedia'] && astra_search.search_results_images ) ? `<span class="ast-search-res-image-wrap">
					<img
						src="${sizes.thumbnail
							? sizes?.thumbnail.source_url
							: values(sizes).reduce(
									(imgSize, current) =>
										current.width <
										imgSize.width
											? current
											: imgSize,
									{
										width: 999999999,
									}
							).source_url ||
							_embedded['wp:featuredmedia'][0].source_url}"
						class="ast-search-result-img"
					/>
				</span>` : '';

				processedHtml += `<a class="ast-search-item" role="option" target="_blank" href="${post.link}"> ${imgHtml} <span> ${searchPostTitle} </span> </a>`;
			});
		});

		return processedHtml;
	}

	window.addEventListener( "load", function(e) {
		const searchInputs = document.querySelectorAll('.search-field');
		searchInputs.forEach(searchInput => {
			searchInput.addEventListener('input', async (event) => {
				const searchForm = searchInput.closest('form.search-form');
				const searchTerm = event.target.value.trim();
				const postTypes = astra_search.search_post_types;

				const searchResultsWrappers = document.querySelectorAll('.ast-live-search-results');
				if ( searchResultsWrappers ) {
					searchResultsWrappers.forEach(function(wrap) {
						wrap.parentNode.removeChild(wrap);
					});
				}

				try {
					const restRequest = `${astra_search.rest_api_url}wp/v2/posts${
						astra_search.rest_api_url.indexOf('?') > -1 ? '&' : '?'
					}_embed=1&post_type=ast_queried:${postTypes.join(':')}&per_page=${
						astra_search.search_posts_per_page
					}&search=${searchTerm}${astra_search.search_language ? `&lang=${astra_search.search_language}` : ''}`;

					const response = await fetch( restRequest );
					const postsData = await response.json();
					let resultsContainer = '';

					if (postsData.length > 0) {
						let formattedPostsData = {}
						postsData.map((post) => {
							if ( post.type in formattedPostsData ) {
								formattedPostsData[post.type].push(post);
							} else {
								formattedPostsData[post.type] = [post];
							}
						});
						let searchResultMarkup = getSearchResultPostMarkup(formattedPostsData);
						resultsContainer = `
							<div
								class="ast-live-search-results"
								role="listbox"
								aria-label="Search results"
								style="top: ${parseInt(searchForm.offsetHeight) + 10}px;"
							>
								${searchResultMarkup}
							</div>
						`;
					} else {
						resultsContainer = `
							<div
								class="ast-live-search-results"
								role="listbox"
								aria-label="Search results"
								style="top: ${parseInt(searchForm.offsetHeight) + 10}px;"
							>
								<label class="ast-search--no-results-heading"> ${astra_search.no_live_results_found} </label>
							</div>
						`;
					}

					const searchResultsWrappers = document.querySelectorAll('.ast-live-search-results');
					if ( searchResultsWrappers ) {
						searchResultsWrappers.forEach(function(wrap) {
							wrap.parentNode.removeChild(wrap);
						});
					}

					searchForm.insertAdjacentHTML('beforeend', resultsContainer);

				} catch (error) {
					console.error('Error while fetching data:', error);
				}
			});
		});
	});

	// Add a click event listener to the document.
	document.addEventListener( 'click', function ( event ) {
		const searchForm = event.target.closest('form.search-form');

		// Check if the clicked element is the search bar or the results dropdown
		if ( null !== searchForm ) {
			// Clicked inside the search bar or dropdown, do nothing
			if ( searchForm.querySelector('.ast-live-search-results') ) {
				searchForm.querySelector('.ast-live-search-results').style.display = 'block';
			}
		} else {
			// Clicked outside the search bar and dropdown, hide the dropdown
			const searchResultsWrappers = document.querySelectorAll('.ast-live-search-results');
			if ( searchResultsWrappers ) {
				searchResultsWrappers.forEach(function(wrap) {
					wrap.style.display = 'none';
				});
			}
		}
	} );

} )();
