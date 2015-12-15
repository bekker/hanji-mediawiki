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
				if ( isset( $box['headerMessage'] ) ) {
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

		?>
		<div class="dropdown" id="<?php echo Sanitizer::escapeId( $box['id'] ) ?>" style="display:inline-block;"
			<?php echo Linker::tooltip( $box['id'] ) ?>>
          <button class="btn btn-default dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
          <?php
				if ( isset( $box['headerMessage'] ) ) {
					$this->msg( $box['headerMessage'] );
				} else {
					echo htmlspecialchars( $box['header'] );
				}
				?> <span class="caret"></span></button>
          <ul class="dropdown-menu">
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
        </div>
		<?php
	}

	private function outputNavDropdown( $box ) {
		if ( !$box['content'] ) {
			return;
		}

		?>
		<li class="dropdown" id="<?php echo Sanitizer::escapeId( $box['id'] ) ?>"
			<?php echo Linker::tooltip( $box['id'] ) ?>>
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
          <?php
				if ( isset( $box['headerMessage'] ) ) {
					$this->msg( $box['headerMessage'] );
				} else {
					echo htmlspecialchars( $box['header'] );
				}
				?> <span class="caret"></span></a>
          <ul class="dropdown-menu">
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
        </li>
		<?php
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
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				  </button>
					<a
						href="<?php echo htmlspecialchars( $this->data['nav_urls']['mainpage']['href'] ) ?>"
						class="navbar-brand"
						<?php echo Xml::expandAttributes( Linker::tooltipAndAccesskeyAttribs( 'p-logo' ) ) ?>
					>
						<img src="<?php $this->text( 'logopath' ) ?>" alt="logo" />
						<span><?php $this->text( 'sitename' ) ?></span>
					</a>
				</div>
				<div class="collapse navbar-collapse" id="bs-navbar-collapse-1">
					<ul class="nav navbar-nav navbar-right" id="navbar-right">
						<li>
						<form
							action="<?php $this->text( 'wgScript' ) ?>"
							role="search"
							class="mw-portlet navbar-form"
							id="p-search"
						>
							<div class="form-group">
								<input type="hidden"name="title" value="<?php $this->text( 'searchtitle' ) ?>" />
								<?php echo $this->makeSearchInput( array( "id" => "searchInput", "class" => "form-control" ) ) ?>
							</div>
							<?php echo $this->makeSearchButton( 'go' , array("class" => "btn btn-default")) ?>
							<!--h3><label for="searchInput"><?php $this->msg( 'search' ) ?></label></h3-->
						</form></li>
						<?php
							$this->outputNavDropdown( array(
								'id' => 'p-personal',
								'headerMessage' => 'personaltools',
								'content' => $this->getPersonalTools(),
							) );

							$this->outputNavDropdown( array(
								'id' => 'p-variants',
								'headerMessage' => 'variants',
								'content' => $this->data['content_navigation']['variants'],
							) );
							foreach ( $this->getSidebar() as $boxName => $box ) {
								$this->outputNavDropdown( $box );
							}

						 ?>
					</ul>
				</div><!--/.nav-collapse -->
			</div>
		</div>
		<div id="mw-wrapper" class="container">
			<div class="mw-body" role="main">
				<div class="body-dropdown">
				<?php
				$this->outputButton( array(
						'id' => 'p-views',
						'headerMessage' => 'views',
						'content' => $this->data['content_navigation']['views'],
					) );
				$this->outputDropdown( array(
								'id' => 'p-namespaces',
								'headerMessage' => 'namespaces',
								'content' => $this->data['content_navigation']['namespaces'],
							) );

				$this->outputDropdown( array(
					'id' => 'p-actions',
					'headerMessage' => 'actions',
					'content' => $this->data['content_navigation']['actions'],
				) );?>
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
			<div class="container">
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
