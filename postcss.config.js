module.exports = {
	plugins: [
		[
			'postcss-preset-env',
			[
				'cssnano',
				{
					preset: [
						'advanced',
						{
							normalizeWhitespace: false,
							discardUnused: false,
							mergeIdents: false,
							reduceIdents: false,
							autoprefixer: {},
						},
					],
				},
			],
		],
	],
};