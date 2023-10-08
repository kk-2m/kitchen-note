document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('ingredient-container');
    
    const deleteButtons = document.querySelectorAll('.ingredient-delete-button');

    deleteButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            // buttonのdata_idを抜き出す
            const dataId = parseInt(button.getAttribute('data-id'));
            const ingredientItem = document.getElementById(`ingredient-item${dataId}`);
            
            if (ingredientItem) {
                // 手順項目を削除
                container.removeChild(ingredientItem);
                // 手順番号を振りなおす
                renumberIngredientItems(dataId);
            }
        });
    });
    
    function renumberIngredientItems(startIndex) {
        let ingredientCount = document.querySelectorAll('.ingredient-item').length;
        console.log(`renumber/ingredientCount:${ingredientCount}`);
        console.log(`startIndex${startIndex}`)
        for (let i = startIndex + 1; i <= ingredientCount + 1; i++) {
            const ingredientItem = document.getElementById(`ingredient-item${i}`);
            console.log(`i = ${i}`)
            console.log(ingredientItem)
            if (ingredientItem) {
                ingredientItem.id = `ingredient-item${i - 1}`;
                console.log(ingredientItem)
                
                const ingredientTitle = ingredientItem.querySelector('h3');
                ingredientTitle.textContent = `材料${i - 1}`;
                const ingredientCategoryLabel = ingredientItem.querySelector(`label[for="ingredient_category${i}"]`);
                ingredientCategoryLabel.htmlFor = `ingredient_category${i - 1}`;
                const ingredientCategorySelect = ingredientItem.querySelector(`#select_ingredient_category${i}`);
                console.log(ingredientCategorySelect);
                ingredientCategorySelect.name = `ingredient[${i - 1}][ingredient_category_id]`;
                ingredientCategorySelect.id = `select_ingredient_category${i - 1}`;
                const ingredientNameLabel = ingredientItem.querySelector(`label[for="ingredient_name${i}"]`);
                console.log(ingredientNameLabel);
                ingredientNameLabel.htmlFor = `ingredient_name${i - 1}`;
                const ingredientNameInput = ingredientItem.querySelector(`#input_ingredient_name${i}`);
                console.log(ingredientNameInput);
                ingredientNameInput.name = `ingredient[${i - 1}][name]`;
                ingredientNameInput.id = `input_ingredient_name${i - 1}`;
                const ingredientQuantityLabel = ingredientItem.querySelector(`label[for="ingredient_quantity${i}"]`);
                console.log(ingredientQuantityLabel);
                ingredientQuantityLabel.htmlFor = `ingredient_quantity${i - 1}`;
                const ingredientQuantityInput = ingredientItem.querySelector(`#input_ingredient_quantity${i}`);
                console.log(ingredientQuantityInput);
                ingredientQuantityInput.name = `ingredient_recipe[${i - 1}][quantity]`;
                ingredientQuantityInput.id = `input_ingredient_quantity${i - 1}`;
                const ingredientUnitLabel = ingredientItem.querySelector(`label[for="ingredient_unit${i}"]`);
                console.log(ingredientUnitLabel);
                ingredientUnitLabel.htmlFor = `ingredient_unit${i - 1}`;
                const ingredientUnitSelect = ingredientItem.querySelector(`#select_ingredient_unit${i}`);
                console.log(ingredientUnitSelect);
                ingredientUnitSelect.name = `ingredient_recipe[${i - 1}][unit_id]`;
                ingredientUnitSelect.id = `select_ingredient_unit${i - 1}`;
                const deleteButton = ingredientItem.querySelector('.ingredient-delete-button');
                deleteButton.dataset.id = i - 1;
            }
        }
    }
    
});