<div class="wsu-programs-list <?php echo esc_attr( $attrs['className'] ); ?>">
	<?php
	if ( true === $attrs['showFilters'] ) {
		?>
		<div class="wsu-programs-list__controls">
			<div class="wsu-programs-list__control--search">
				<input class="wsu-programs-list__search-input" type="text" placeholder="Search Degree Programs">
			</div>

			<div class="wsu-programs-list__control-group js-programs-list__select-controls">
				<div class="wsu-programs-list__control--select">
					<button class="wsu-button wsu-button--tertiary wsu-button--size-small wsu-programs-list__control-button" aria-expanded="false">
						<span class="wsu-programs-list__button-text">Area of Interest</span>
						<i class="wsu-icon wsu-i-arrow-down-carrot wsu-programs-list__button-icon"></i>
					</button>
					<div class="wsu-programs-list__filter-options">
						<?php
						foreach ( $area_terms as $t ) {
							?>
								<div class="wsu-programs-list__filter-option">
									<input class="js-programs-list__filter-option-input" type="checkbox" id="area-<?php echo esc_attr( $t['slug'] ); ?>" name="area" value="<?php echo esc_attr( $t['slug'] ); ?>" />
									<label for="area-<?php echo esc_attr( $t['slug'] ); ?>"><?php echo esc_attr( $t['name'] ); ?></label>
								</div>
							<?php
						}
						?>
					</div>
				</div>
				<div class="wsu-programs-list__control--select">
					<button class="wsu-button wsu-button--tertiary wsu-button--size-small wsu-programs-list__control-button" aria-expanded="false">
						<span class="wsu-programs-list__button-text">Degree Type</span>
						<i class="wsu-icon wsu-i-arrow-down-carrot wsu-programs-list__button-icon"></i>
					</button>
					<div class="wsu-programs-list__filter-options">
						<?php
						foreach ( $degree_type_terms as $t ) {
							?>
								<div class="wsu-programs-list__filter-option">
									<input class="js-programs-list__filter-option-input" type="checkbox" id="degree-type-<?php echo esc_attr( $t['slug'] ); ?>" name="degreeType" value="<?php echo esc_attr( $t['slug'] ); ?>" />
									<label for="degree-type-<?php echo esc_attr( $t['slug'] ); ?>"><?php echo esc_attr( $t['name'] ); ?></label>
								</div>
							<?php
						}
						?>
					</div>
				</div>
				<div class="wsu-programs-list__control--select">
					<button class="wsu-button wsu-button--tertiary wsu-button--size-small wsu-programs-list__control-button" aria-expanded="false">
						<span class="wsu-programs-list__button-text">Campus</span>
						<i class="wsu-icon wsu-i-arrow-down-carrot wsu-programs-list__button-icon"></i>
					</button>
					<div class="wsu-programs-list__filter-options">
						<?php
						foreach ( $campus_terms as $t ) {
							?>
								<div class="wsu-programs-list__filter-option">
									<input class="js-programs-list__filter-option-input" type="checkbox" id="campus-<?php echo esc_attr( $t['slug'] ); ?>" name="campus" value="<?php echo esc_attr( $t['slug'] ); ?>" />
									<label for="campus-<?php echo esc_attr( $t['slug'] ); ?>"><?php echo esc_attr( $t['name'] ); ?></label>
								</div>
							<?php
						}
						?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
	?>

	<div class="js-programs-list__list-groups">
		<?php
		foreach ( $grouped_programs as $group => $programs ) {
			?>
			<div id="program-group-<?php echo strtolower( esc_attr( $group ) ); ?>" class="wsu-programs-list__list-group">
				<<?php echo esc_attr( $attrs['headingLevel'] ); ?> class="wsu-programs-list__list-heading"><?php echo esc_attr( $group ); ?></<?php echo esc_attr( $attrs['headingLevel'] ); ?>>
				<ol class="wsu-programs-list__list">
					<?php
					foreach ( $programs as $program ) {
						$campus_degrees_string = '';
						$areas_string          = $program['areas_of_study'] ? implode(
							'|',
							array_map(
								function( $a ) {
									return $a->slug;
								},
								$program['areas_of_study']
							)
						) : '';

						if ( ! empty( $program['campus_degrees'] ) ) {
							foreach ( $program['campus_degrees'] as $campus_id => $degree_ids ) {
								if ( ! empty( $degree_ids ) ) {
									foreach ( $degree_ids as $degree_id ) {
										$campus_degrees_string .= $campus_terms[ $campus_id ]['slug'] . '--' . $degree_type_terms[ $degree_id ]['slug'] . '|';
									}
								}
							}
						}
						?>
						<li
							id="program-<?php echo esc_attr( $program['id'] ); ?>"
							class="wsu-programs-list__list-item"
							data-title="<?php echo esc_attr( $program['title'] ); ?>"
							data-areas="<?php echo esc_attr( $areas_string ); ?>"
							data-campus-degrees="<?php echo esc_attr( rtrim( $campus_degrees_string, '|' ) ); ?>">
							<?php
							if ( ! empty( $program['url'] ) ) {
								echo '<a href="' . esc_attr( $program['url'] ) . '" class="wsu-programs-list__list-link">' . esc_attr( $program['title'] ) . '</a>';
							} else {
								echo '<span class="wsu-programs-list__list-link">' . esc_attr( $program['title'] ) . '</span>';
							}
							?>
							<div class="wsu-programs-list__degree-types">
								<?php
								if ( ! empty( $program['campus_degrees'] ) ) {
									$degree_options = array_unique(
										array_reduce(
											$program['campus_degrees'],
											function( $acc, $cur ) {
												$acc = array_merge( $acc, $cur );
												return $acc;
											},
											array()
										)
									);

									foreach ( $degree_options as $degree_id ) {
										$degree_name = $degree_type_terms[ $degree_id ]['name'];

										$campuses = array_filter(
											$program['campus_degrees'],
											function( $degrees ) use ( $degree_id ) {
												return in_array( $degree_id, $degrees );
											}
										);

										$campus_names = implode(
											'|',
											array_map(
												function( $campus ) use ( $campus_terms ) {
													return $campus_terms[ $campus ]['slug'];
												},
												array_keys( $campuses )
											)
										);

										echo '<span class="wsu-programs-list__degree-type" data-campuses="' . esc_attr( $campus_names ) . '">' . esc_attr( $degree_name ) . '</span>';
									}
								}
								?>
							</div>
						</li>
						<?php
					}
					?>
				</ol>
			</div>
			<?php
		}
		?>
		</div>
</div>
