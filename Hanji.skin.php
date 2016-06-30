<?php
/**
 * Skin file for the Hanji skin.
 *
 * @file
 * @ingroup Skins
 */

/**
 * SkinTemplate class
 *
 * @ingroup Skins
 */
class SkinHanji extends SkinTemplate {
	public $skinname = 'hanji', $stylename = 'Hanji',
		$template = 'HanjiTemplate', $useHeadElement = true;


	public function initPage( OutputPage $out ) {
		parent::initPage( $out );
		$out->addHeadItem('viewport', '<meta name="viewport" content="width=device-width,initial-scale=1">');
	}

	/**
	 * Add CSS via ResourceLoader
	 *
	 * @param $out OutputPage
	 */
	function setupSkinUserCss( OutputPage $out ) {
		parent::setupSkinUserCss( $out );
		$out->addModuleStyles( array(
			'mediawiki.skinning.interface', 'skins.hanji.styles'
		));
		$out->addModuleScripts( array('skins.hanji.js'));
	}
}

/**
 * BaseTemplate class
 *
 * @ingroup Skins
 */
class HanjiTemplate extends BaseTemplate {
	/**
	 * Outputs a single sidebar portlet of any kind.
	 */
	private function outputPortlet( $box ) {
		if ( !$box['content'] ) {
			return;
		}

		?>
		<div
			role="navigation"
			class="mw-portlet"
			id="<?php echo Sanitizer::escapeId( $box['id'] ) ?>"
			<?php echo Linker::tooltip( $box['id'] ) ?>
		>
			<h3>
				<?php
				if ( isset( $box['headerSafe'] ) ) {
					echo $box['headerSafe'];
				} else if ( isset( $box['headerMessage'] ) ) {
					$this->msg( $box['headerMessage'] );
				} else {
					echo htmlspecialchars( $box['header'] );
				}
				?>
			</h3>

			<?php
			if ( is_array( $box['content'] ) ) {
				echo '<ul>';
				foreach ( $box['content'] as $key => $item ) {
					echo $this->makeListItem( $key, $item);
				}
				echo '</ul>';
			} else {
				echo $box['content'];
			}?>
		</div>
		<?php
	}

	private function outputDropdown( $box ) {
		if ( !$box['content'] ) {
			return;
		}

		?><div class="dropdown" id="<?php echo Sanitizer::escapeId( $box['id'] ) ?>" style="display:inline-block;"
			<?php echo Linker::tooltip( $box['id'] ) ?>>
          <button class="btn btn-default dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			<?php
				if ( isset( $box['headerSafe'] ) ) {
					echo $box['headerSafe'];
				} else if ( isset( $box['headerMessage'] ) ) {
					$this->msg( $box['headerMessage'] );
				} else {
					echo htmlspecialchars( $box['header'] );
				}
				?> <span class="caret"></span></button>
				<ul class="dropdown-menu <?php if (isset($box['ulClass'])) echo $box['ulClass'] ?>">
          <?php
			if ( is_array( $box['content'] ) ) {
				echo '<li>';
				foreach ( $box['content'] as $key => $item ) {
					echo $this->makeListItem( $key, $item );
				}
				echo '</li>';
			} else {
				echo '<li>';
				echo $box['content'];
				echo '</li>';
			}?>
          </ul>
        </div><?php
	}

	private function outputDropdownMulti( $box ) {
		if ( !$box['content'] ) {
			return;
		}

		?><div class="dropdown" id="<?php echo Sanitizer::escapeId( $box['id'] ) ?>" style="display:inline-block;"
			<?php echo Linker::tooltip( $box['id'] ) ?>>
          <button class="btn btn-default dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			<?php
				if ( isset( $box['headerSafe'] ) ) {
					echo $box['headerSafe'];
				} else if ( isset( $box['headerMessage'] ) ) {
					$this->msg( $box['headerMessage'] );
				} else {
					echo htmlspecialchars( $box['header'] );
				}
				?> <span class="caret"></span></button>
		<ul class="dropdown-menu <?php if (isset($box['ulClass'])) echo $box['ulClass'] ?>">
<?php
			$i = 0;
			foreach ( $box['content'] as $boxName => $box_) {
				if ( $box_['id'] == $box['exclude'] ) continue;
				if ($i != 0) {
						?><li role="separator" class="divider"></li><?php
				}
				if ( is_array( $box_['content'] ) ) {
					echo '<li>';
					foreach ( $box_['content'] as $key => $item ) {
						echo $this->makeListItem( $key, $item );
					}
					echo '</li>';
				} else {
					echo '<li>';
					echo $box_['content'];
					echo '</li>';
				}
				$i++;
			}?>
          </ul>
        </div><?php
	}

	private function outputNavDropdown( $box ) {
		if ( !$box['content'] ) {
			return;
		}

		?><li class="dropdown" id="<?php echo Sanitizer::escapeId( $box['id'] ) ?>"<?php echo Linker::tooltip( $box['id'] ) ?>>
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
				<?php 
				if ( isset( $box['headerSafe'] ) ) {
					echo $box['headerSafe'];
				} else if ( isset( $box['headerMessage'] ) ) {
					$this->msg( $box['headerMessage'] );
				} else {
					echo htmlspecialchars( $box['header'] );
				}
				?> <span class="caret"></span></a>
					<ul class="dropdown-menu <?php if (isset($box['ulClass'])) echo $box['ulClass'] ?>">
<?php
			if ( is_array( $box['content'] ) ) {
				echo '<li>';
				foreach ( $box['content'] as $key => $item ) {
					echo $this->makeListItem( $key, $item );
				}
				echo '</li>';
			} else {
				echo $box['content'];
			}?>
          </ul>
        </li><?php
	}

	private function outputButton( $box ) {
		if ( !$box['content'] ) {
			return;
		}

		?>
		<?php
			if ( is_array( $box['content'] ) ) {
				foreach ( $box['content'] as $key => $item ) {
					echo $this->makeListItem( $key, $item, array('tag' => 'button', 'class' => 'btn btn-default') );
				}
			} else {
				echo $box['content'];
			}
	}

	/**
	 * Outputs the entire contents of the page
	 */
	public function execute() {
		$this->html( 'headelement' ) ?>
		<div class="navbar navbar-inverse navbar-static-top" role="navigation" id="nav">
			<div class="container">
				<div class="navbar-header">
					<a
						href="<?php echo htmlspecialchars( $this->data['nav_urls']['mainpage']['href'] ) ?>"
						class="navbar-brand"
						<?php echo Xml::expandAttributes( Linker::tooltipAndAccesskeyAttribs( 'p-logo' ) ) ?>
					>
						<img src="<?php $this->text( 'logopath' ) ?>" alt="logo" />
						<span><?php $this->text( 'sitename' ) ?></span>
					</a>
				</div>
				<ul class="nav nav-dropdown">
					<?php
					$this->outputNavDropdown( array(
						'id' => 'p-variants',
						'headerMessage' => 'variants',
						'content' => $this->data['content_navigation']['variants'],
				) );
					foreach ( $this->getSidebar() as $boxName => $box ) {
						if ( $box['id'] === "p-navigation")
							$this->outputNavDropdown( $box );
					}
					?>
				</ul>

				<div class="nav nav-dropdown navbar-right">
					<?php
					$this->outputNavDropdown( array(
						'id' => 'p-personal',
						'headerSafe' => '<span class="glyphicon glyphicon-user" aria-hidden="true"></span>',
						'content' => $this->getPersonalTools(),
						'ulClass' => "dropdown-menu-right",
					) );
					?>
				</div>
				<div class="nav navbar-nav navbar-right search-box">
					<form
						action="<?php $this->text( 'wgScript' ) ?>"
						role="search"
						class="mw-portlet"
						id="p-search"
					>
						<div class="form-group">
							<input type="hidden"name="title" value="<?php $this->text( 'searchtitle' ) ?>" />
							<?php echo $this->makeSearchInput( array( "id" => "searchInput", "class" => "form-control" ) );
							echo $this->makeSearchButton( 'go' , array( "id" => "searchBtn", "class" => "btn btn-default")) ?>
						</div>
						<!--h3><label for="searchInput"><?php $this->msg( 'search' ) ?></label></h3-->
					</form>
				</div>
			</div>
		</div>
		<div id="body-wrapper" class="container">
			<div id="mw-wrapper">
				<div class="mw-body" role="main">
					<div class="body-dropdown-wrapper">
						<div class="body-dropdown">
							<?php
							$this->outputDropdown( array(
								'id' => 'p-views',
								'headerMessage' => 'views',
								'content' => $this->data['content_navigation']['views'],
								//'ulClass' => "dropdown-menu-right",
							) );
							$this->outputDropdown( array(
								'id' => 'p-namespaces',
								'headerMessage' => 'namespaces',
								'content' => $this->data['content_navigation']['namespaces'],
								//'ulClass' => "dropdown-menu-right",
							) );

							$this->outputDropdown( array(
								'id' => 'p-actions',
								'headerMessage' => 'actions',
								'content' => $this->data['content_navigation']['actions'],
								'ulClass' => "dropdown-menu-right",
							) );
							$this->outputDropdownMulti( array(
								'id' => 'p-tb',
								'headerMessage' => 'toolbox',
								'content' => $this->getSidebar(),
								'exclude' => 'p-navigation',
								'ulClass' => "dropdown-menu-right",
							) );
							?>
						</div>
					</div>

					<?php if ( $this->data['sitenotice'] ) { ?>
						<div id="siteNotice"><?php $this->html( 'sitenotice' ) ?></div>
					<?php } ?>

					<?php if ( $this->data['newtalk'] ) { ?>
						<div class="usermessage"><?php $this->html( 'newtalk' ) ?></div>
					<?php } ?>

					<h1 class="firstHeading">
						<?php $this->html( 'title' ) ?>
					</h1>

					<div id="siteSub"><?php $this->msg( 'tagline' ) ?></div>

					<div class="mw-body-content">
						<div id="contentSub">
							<?php if ( $this->data['subtitle'] ) { ?>
								<p><?php $this->html( 'subtitle' ) ?></p>
							<?php } ?>
							<?php if ( $this->data['undelete'] ) { ?>
								<p><?php $this->html( 'undelete' ) ?></p>
							<?php } ?>
						</div>

						<?php $this->html( 'bodytext' ) ?>
						<!------bodytext end ------->
						<?php $this->html( 'catlinks' ) ?>

						<?php $this->html( 'dataAfterContent' ); ?>

					</div>
				</div>


				<!--div id="mw-navigation">
				<h2><?php $this->msg( 'navigation-heading' ) ?></h2>

				<?php

				?>
			</div-->

			</div>
			<hr>
			<div id="mw-footer">
				<div class="row">
					<div class="col-md-6">
						<?php foreach ( $this->getFooterLinks() as $category => $links ) { ?>
							<ul role="contentinfo">
								<?php foreach ( $links as $key ) { ?>
									<li><?php $this->html( $key ) ?></li>
								<?php } ?>
							</ul>
						<?php } ?>
					</div>
					<div class="col-md-6">
						<ul role="contentinfo">
							<?php foreach ( $this->getFooterIcons( 'icononly' ) as $blockName => $footerIcons ) { ?>
								<li>
									<?php
									foreach ( $footerIcons as $icon ) {
										echo $this->getSkin()->makeFooterIcon( $icon );
									}
									?>
								</li>
							<?php } ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<?php $this->printTrail() ?>
		</body></html>

		<?php
	}
}
