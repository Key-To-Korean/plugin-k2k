<?php
/**
 * The sidebar containing the Reading Filters
 *
 * @link Inspiration: https://laracasts.com/search?refinement=type&name=series
 *
 * @package K2K
 */

?>

<!-- <aside id="secondary" class="primary-sidebar widget-area"> -->
	<aside id="reading-filter-box" class="k2k-sidebar reading-sidebar <?php echo is_archive() ? 'archive-page' : ''; ?>">

		<!-- Sortable / Filterable Terms Lists -->
		<?php
			$taxonomies   = [];
			$taxonomies[] = get_terms(
				array(
					'taxonomy'   => 'k2k-reading-level',
					'hide_empty' => false,
				)
			);
			$taxonomies[] = get_terms(
				array(
					'taxonomy'   => 'k2k-reading-genre',
					'hide_empty' => false,
				)
			);
			$taxonomies[] = get_terms(
				array(
					'taxonomy'   => 'k2k-reading-topic',
					'hide_empty' => false,
				)
			);

			$icons = [ '⚡️', '📗', '🏷' ];

			if ( ! empty( $taxonomies ) ) :
				?>

			<div class="k2k-filters">

				<?php
				$i = 0;
				foreach ( $taxonomies as $t ) :

					if ( empty( $t ) ) {
						continue;
					}

					$tax_name = ucwords( str_replace( array( '-', '_' ), ' ', esc_attr( substr( $t[0]->taxonomy, 11 ) ) ) );
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
								<option value="<?php echo esc_url( get_home_url() ) . '/reading/'; ?>">
									<?php echo esc_html( $icons[ $i ] . $tax_name ); ?>
								</option>
								<?php
							}

							$t = $category->taxonomy;
							?>

							<option value="<?php echo esc_url( get_home_url() ) . '/reading/' . esc_attr( substr( $t, 12 ) ) . '/' . esc_attr( $category->slug ) . '/'; ?>">
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
						<a href="<?php echo esc_url( home_url() ); ?>/reading/">
							<span class="index-home reading" title="<?php esc_html_e( 'Reading Index', 'k2k' ); ?>">🏠</span>
						</a>
					</span>
					<?php display_reading_search_form(); ?>
				</div>

				<?php
			endif;
			?>

		<!-- Add ReactJS -->
		<!-- <div id="reading_root"></div> -->
		<!-- End ReactJS -->

		<!-- <h4 class="reading-filter-heading">😤 Difficulty</h4> -->

		<!-- Book -->
		<!-- <h4 class="reading-filter-heading">😤 Book</h4> -->

		<!-- Usage -->
		<!-- <h4 class="reading-filter-heading">😤 Usage</h4> -->

		<!-- Expression -->
		<!-- <h4 class="reading-filter-heading">😤 Expression</h4> -->

	</aside>
<!-- </aside>#secondary -->
