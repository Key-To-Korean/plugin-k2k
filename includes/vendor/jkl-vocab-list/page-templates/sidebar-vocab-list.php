<?php
/**
 * The sidebar containing the Grammar Filters
 *
 * @link Inspiration: https://laracasts.com/search?refinement=type&name=series
 *
 * @package K2K
 */

?>

<!-- <aside id="secondary" class="primary-sidebar widget-area"> -->
	<aside id="grammar-filter-box" class="k2k-sidebar vocabulary-sidebar <?php echo is_archive() ? 'archive-page' : ''; ?>">

		<!-- Sortable / Filterable Terms Lists -->
		<?php
			$taxonomies   = [];
			$taxonomies[] = get_terms(
				array(
					'taxonomy'   => 'k2k-vocab-level',
					'hide_empty' => false,
				)
			);
			$taxonomies[] = get_terms(
				array(
					'taxonomy'   => 'k2k-vocab-part-of-speech',
					'hide_empty' => false,
				)
			);
			$taxonomies[] = get_terms(
				array(
					'taxonomy'   => 'k2k-vocab-topic',
					'hide_empty' => false,
				)
			);
			$taxonomies[] = get_terms(
				array(
					'taxonomy'   => 'k2k-vocab-group',
					'hide_empty' => false,
				)
			);

			$icons = [ '⚡️', '🗣', '🏷', '📗' ];

			if ( ! empty( $taxonomies ) ) :
				?>

			<div class="k2k-filters">

				<?php
				$i = 0;
				foreach ( $taxonomies as $t ) :

					if ( empty( $t ) ) {
						continue;
					}

					$tax_name = ucwords( str_replace( array( '-', '_' ), ' ', esc_attr( substr( $t[0]->taxonomy, 9 ) ) ) );
					?>

					<div class="k2k-filter">

					<?php
					if ( ! empty( $t ) ) :
						?>

						<select onchange="<?php echo 'if (this.value) window.location.href=this.value'; ?>">

						<?php
						foreach ( $t as $key => $category ) :

							if ( 0 === $key ) {
								?>
								<option value="<?php echo esc_url( get_home_url() ) . '/vocabulary/'; ?>">
									<?php echo esc_html( $icons[ $i ] . $tax_name ); ?>
								</option>
								<?php
							}

							$t = $category->taxonomy;
							?>

							<option value="<?php echo esc_url( get_home_url() ) . '/vocabulary/' . esc_attr( substr( $t, 10 ) ) . '/' . esc_attr( $category->slug ) . '/'; ?>">
								<?php echo esc_html( $category->name ) . ' (' . esc_attr( $category->count ) . ')'; ?>
							</option>

							<?php
						endforeach;
						?>

						</select>

						<?php
					endif;

					$i++;
					?>

				</div>

					<?php
				endforeach;
				?>

				</div>

				<!-- Search -->
				<div class="k2k-index-search">
					<span class="k2k-index-link">
						<a href="<?php echo esc_url( home_url() ); ?>/vocabulary/">
							<span class="index-home vocabulary" title="<?php esc_html_e( 'Vocabulary Index', 'k2k' ); ?>">🏠</span>
						</a>
					</span>
					<?php display_vocabulary_search_form(); ?>
				</div>

				<?php
			endif;
			?>

		<!-- Add ReactJS -->
		<!-- <div id="grammar_root"></div> -->
		<!-- End ReactJS -->

		<!-- <h4 class="grammar-filter-heading">😤 Difficulty</h4> -->

		<!-- Book -->
		<!-- <h4 class="grammar-filter-heading">😤 Book</h4> -->

		<!-- Usage -->
		<!-- <h4 class="grammar-filter-heading">😤 Usage</h4> -->

		<!-- Expression -->
		<!-- <h4 class="grammar-filter-heading">😤 Expression</h4> -->

	</aside>
<!-- </aside>#secondary -->
