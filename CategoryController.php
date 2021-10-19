<?php

require ("CategoryModel.php");

//Contains non-database related function for the category page
class CategoryController {
    
    function CreateCategoryTables(/*$types*/)
    {
        $CategoryModel = new CategoryModel();
		$CategoriesArray = $CategoryModel->GetAllCategories();
        $result = "";
        
		$result = $result . 
			
		"
		<div class = 'row'>
			<div class = 'coulmn'>";
			
		$i=0;	
		$flag=0;
        //Generate a categoryTable for each productEntity in array
        foreach ($CategoriesArray as $key => $category) 
        {
			$result = $result .
                    "
					<form action='ProductsWindow.php?action=view&code=$category->CategoryName' class='container' style ='cursor: pointer' method='post'>
						<input  type='image' src=$category->Image>
							<div class='content' style='background: rgba(0, 0, 0, 0.5);'>
								<h1>$category->CategoryName</h1>
								<p>$category->Description</p>
							</div>
						</input>
					</form>";
					
		}     
			$result=$result."</div></div>";
        return $result; 
    }
	

}
?>
