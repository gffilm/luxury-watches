<div class="clearfix">
		<?php foreach ($watches as $watch): ?>
				<?php $brand = strtolower(str_replace(' ', '-', $watch->brand)); ?>
				<?php $imagePath = 'images/inventory/logos/'  . $brand . '.png'; ?>
				<a href="/brands/<?php echo $watch->brand ?>/<?php echo $watch->brand_id ?>" title="<?php echo $watch->brand ?>" class="inventory-item">
					 <img src="<?php Resource::getInstance()->echoPath($imagePath); ?>" border="0" />
				</a>
		<?php endforeach; ?>
</div>

