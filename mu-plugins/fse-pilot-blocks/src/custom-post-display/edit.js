/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';
import { useState } from "react";
import Select from 'react-select';
/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { __experimentalUnitControl as UnitControl } from '@wordpress/components';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import ServerSideRender from '@wordpress/server-side-render';
import {
	Disabled,
	ToggleControl,
	PanelBody,
	PanelRow,
	QueryControls,
	SelectControl
} from '@wordpress/components';


import { MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';
import metadata from './block.json';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit({ attributes , setAttributes }) {
	
	let post_type = attributes.post_type;
	let select_types = "";
	if( post_type == '' ) {
		post_type  = "{}";
	} else {
		JSON.parse(post_type).forEach(myFunction);
		function myFunction(value, index, array) {
			select_types += (select_types!=''?'_-_':'')+value.value;
		}
	}

	let types = [];
	wp.apiFetch({ path: 'fse/post-types' }).then(
		posts => posts.map(function (post) {
			types.push( { value : post.value, label : post.label } )
		})
	);
	
	let categories = [];
	wp.apiFetch({ path: 'fse/categories/'+select_types }).then( //'fse/categories'
		cats => cats.map(function (cat) {
			categories.push( { value : cat.value, label : cat.label } )
		})
	);
	
	// let is_featured = attributes.is_featured;
	// const [ hasIsFeatured, setIsFeatured ] = useState( is_featured );

	
	const handlePostTypeChange = ( post_type ) => { 

		setAttributes( { post_type: JSON.stringify( post_type ) } )  

		let select_types = "";
		post_type.forEach(myFunction);
		function myFunction(value, index, array) {
			select_types += (select_types!=''?'_-_':'')+value.value;
		}

		categories = [];
		wp.apiFetch({ path: 'fse/categories/'+select_types }).then( 
			cats => cats.map(function (cat) {
				
				categories.push( { value : cat.value, label : cat.label } )
			})
		);
		console.log(categories)
		
	};

	let category = attributes.category;
	if( category == '' ) {
		category  = "{}";
	}
	const handleCategoriesChange = ( category ) => setAttributes( { category: JSON.stringify( category ) } );


	const blockProps = useBlockProps( {
		className: 'wz-fse-gutenberg',
	} );
	
	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Settings', 'fse-pilot-blocks' ) } initialOpen={ true } >
					<PanelRow>
						<label>{__("Post Types", "ldninjas-gutenberg-toolkit")}</label>
					</PanelRow>
					<PanelRow>
						<Select
							name='post_type'
							value={ JSON.parse( post_type ) }
							onChange={ handlePostTypeChange }
							options={types}
							isMulti='true'
							/>
						
					</PanelRow>
					<PanelRow>
						<label>{__("Categories", "ldninjas-gutenberg-toolkit")}</label>
					</PanelRow>
					<PanelRow>
						<Select
							name='categories'
							value={ JSON.parse( category ) }
							onChange={ handleCategoriesChange }
							options={categories}
							isMulti='false'
							/>
						
					</PanelRow>
					{/* <PanelRow>
						<ToggleControl
								label={ __( 'Is Featured', 'fse-pilot-blocks' ) }
								help={
									hasIsFeatured
										? __( 'Hide block on Desktop.', 'fse-pilot-blocks' )
										: __( 'Show block on Desktop.', 'fse-pilot-blocks' )
								}
								checked={ hasIsFeatured }
								onChange={ (newValue) => {
									setIsFeatured( newValue );
									setAttributes({is_featured: newValue})
								} }
							/>
					</PanelRow> */}
					
				</PanelBody>
			</InspectorControls>

			<div { ...blockProps }>
				<Disabled>
					<ServerSideRender
						block={ metadata.name }
						skipBlockSupportAttributes
						attributes={ attributes }
					/>
				</Disabled>
			</div>
		</>
	);
}
