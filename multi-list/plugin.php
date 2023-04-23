<?php
class multiList extends Plugin
{

	public function init()
	{
		$this->dbFields = array(

			'categorytitle' => 'Categories list',
			'categorybutton' => 'Check categories',
			'turnoncategories' => '',
			'categoriescount' => '10',
			'viewcategories' => 'form',

			'tagstitle' => 'Tags list',
			'tagsbutton' => 'Check tags',
			'turnontags' => '',
			'tagscount' => '10',

			'viewtags' => 'form',
		);
	}

	public function form()
	{

		$html = '

		<h3>Settings Categories List</h3>
		<p>Turn on Categories?</p>
		<select name="turnoncategories">
<option value="yes" ' . ($this->getValue('turnoncategories') == 'yes' ? 'selected' : '') . '>Yes</option>
<option value="no"  ' . ($this->getValue('turnoncategories') == 'no' ? 'selected' : '') . '>No</option>
		</select>

		<br>

		<p>View mode for categories</p>
		<select name="viewcategories">
<option value="form" ' . ($this->getValue('viewcategories') == 'form' ? 'selected' : '') . '>form</option>
<option value="list"  ' . ($this->getValue('viewcategories') == 'list' ? 'selected' : '') . '>list</option>
		</select>

<br>
		<p>Categories Title</p>
		<input type="text" name="categorytitle" value="' . $this->getValue('categorytitle') . '">
		<br>
		<p>Categories Button</p>
		<input type="text" name="categorybutton" value="' . $this->getValue('categorybutton') . '">
<br>
		<p>Categories limit</p>
		<input type="text" name="categoriescount" value="' . $this->getValue('categoriescount') . '">

		<hr>


		
		<h3>Settings Tags List</h3>
		<p>Turn on Tags?</p>
		<select name="turnontags">
<option value="yes" ' . ($this->getValue('turnontags') == 'yes' ? 'selected' : '') . '>Yes</option>
<option value="no"  ' . ($this->getValue('turnontags') == 'no' ? 'selected' : '') . '>No</option>
		</select>
		<br>
		<p>View mode for tags</p>
		<select name="viewtags">
<option value="form" ' . ($this->getValue('viewtags') == 'form' ? 'selected' : '') . '>form</option>
<option value="list"  ' . ($this->getValue('viewtags') == 'list' ? 'selected' : '') . '>list</option>
		</select>
<br>
		<p>Tags Title</p>
		<input type="text" name="tagstitle" value="' . $this->getValue('tagstitle') . '">
		<br>
		<p>Tags Button</p>
		<input type="text" name="tagsbutton" value="' . $this->getValue('tagsbutton') . '">
<br>
		<p>Tags limit</p>
		<input type="text" name="tagscount" value="' . $this->getValue('tagscount') . '">

		<hr>

		<div class="bg-light col-md-12 my-3  d-flex py-2 justify-content-between text-center border">
      
<p class="lead m-0">buy me ☕ if you want saw new plugins:)  </p>

<a href="https://www.paypal.com/donate/?hosted_button_id=TW6PXVCTM5A72">
<img alt="" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" border="0">
</a>

</div>
		';

		return $html;
	}

	public function siteSidebar()
	{


		//categories 

		if ($this->getValue('turnoncategories') == 'yes') {

			global $categories;

			function sortByOrderCat($a, $b)
			{
				if ($a['list'] < $b['list']) {
					return 1;
				} elseif ($a['list'] > $b['list']) {
					return -1;
				}
				return 0;
			};

			usort($categories->db, 'sortByOrderCat');

			$countCat = 0;


			if ($this->getValue('viewcategories') == 'form') {

				echo '<form class="category-form" style="margin:10px 0">
			<h5>' . $this->getValue('categorytitle') . '</h5>
			<select class="category-select" style="width:100%;background:#fff;border:solid 1px #ddd;padding:10px;">';
				foreach ($categories->db as $key => $fields) {

					if ($countCat < $this->getValue('categoriescount')) {
						echo '<option value="' . DOMAIN_CATEGORIES . strtolower(str_replace(' ', '-', $fields['name'])) . '">' . '(' . count($fields['list']) . ') ' . $fields['name'] . '</option>';
					};
					$countCat++;
				};

				echo '</select>
			<input type="submit" value="' . $this->getValue('categorybutton') . '" style="background:#000;border:none;margin-top:10px;color:#fff; padding:10px;">
			</form>';


				echo '<script>
			
			const categoryForm = document.querySelector(".category-form");
			
			categoryForm.querySelector(`input[type="submit"]`).addEventListener("click",(e)=>{
			
				e.preventDefault();
				window.location.href = document.querySelector(".category-select").value;
				 
			})
			
			
			if(document.querySelector(`select.category-select option[value="${window.location.href }"]`) !==null){
				document.querySelector(".category-select").value = decodeURI(window.location.href);
			};
			
			
			</script>';
			} else {

				echo '
				<style>

				.cat-list{
					display:flex;flex-wrap:wrap;
					margin:10px 0;
				}
				.cat-list a{
				background:#fafafa;border:solid 1px #ddd;
				margin-right:5px;
				margin-bottom:10px;
				color:#333;
				padding:5px;display:inline-block;
				transition:all 250ms linear;
				font-size:14px;
				}

				.cat-list a:hover{
				text-decoration:none;
				color:#fff;
				background:#000;
				}

				</style>
				
				';


				echo '<h5>' . $this->getValue('categorytitle') . '</h5>';
				echo '<div class="cat-list">';
				foreach ($categories->db as $key => $fields) {

					if ($countCat < $this->getValue('categoriescount')) {
						echo '<a href="' . DOMAIN_CATEGORIES . strtolower(str_replace(' ', '-', $fields['name'])) . '" > ' . '(' . count($fields['list']) . ') ' . $fields['name'] . '</a>';
					};
					$countCat++;
				};

				echo '</div>';
			}
		};





		if ($this->getValue('turnontags') == 'yes') {

			global $tags;


			function sortByOrder($a, $b)
			{
				if ($a['list'] < $b['list']) {
					return 1;
				} elseif ($a['list'] > $b['list']) {
					return -1;
				}
				return 0;
			};

			usort($tags->db, 'sortByOrder');

			$count = 0;


			if ($this->getValue('viewtags') == 'form') {

				echo '<form class="tag-form" style="margin:10px 0">
			<h5>' . $this->getValue('tagstitle') . '</h5>
			<select class="tag-select" style="width:100%;background:#fff;border:solid 1px #ddd;padding:10px;">';
				foreach ($tags->db  as $key => $fields) {

					if ($count < $this->getValue('tagscount')) {
						echo '<option value="' . DOMAIN_TAGS . strtolower(str_replace(' ', '-', $fields['name'])) . '">' . '(' . count($fields['list']) . ') ' . $fields['name'] . '</option>';
					};
					$count++;
				};

				echo '</select>
			<input type="submit" value="' . $this->getValue('tagsbutton') . '" style="background:#000;border:none;margin-top:10px;color:#fff; padding:10px;">
			</form>';


				echo '<script>
		
			const tagForm = document.querySelector(".tag-form");
		
			tagForm.querySelector(`input[type="submit"]`).addEventListener("click",(e)=>{
		
				e.preventDefault();
				window.location.href = document.querySelector(".tag-select").value;
				 
			})
		
		
			if(document.querySelector(`select.tag-select option[value="${window.location.href }"]`) !==null){
				document.querySelector(".tag-select").value = decodeURI(window.location.href);
			};
			
		
			</script>';
			} else {

				echo '
				<style>

				.tag-list{
					display:flex;flex-wrap:wrap;
					margin:10px 0;
				}
				.tag-list a{
				background:#fafafa;border:solid 1px #ddd;
				margin-right:5px;
				color:#333;
				margin-bottom:10px;
				padding:5px;display:inline-block;
				transition:all 250ms linear;
				font-size:14px;
				}


				.tag-list a:hover{
				text-decoration:none;
				color:#fff;
				background:#000;
				}

				</style>
				
				';

				echo '<h5>' . $this->getValue('tagstitle') . '</h5>';
				echo '<div class="tag-list">';

				foreach ($tags->db  as $key => $fields) {

					if ($count < $this->getValue('tagscount')) {
						echo '<a href="' . DOMAIN_TAGS . strtolower(str_replace(' ', '-', $fields['name'])) . '">' . '(' . count($fields['list']) . ') ' . $fields['name'] . '</a>';
					};
					$count++;
				};

				echo '</div>';
			};
		};
	}
}
