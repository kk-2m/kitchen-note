document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('ingredient-container');
    const addButton = document.getElementById('add-ingredient');
    const ingredientCategoryData = JSON.parse(container.dataset.ingredientcategories);
    // console.log(ingredientCategoryData);
    const unitData = JSON.parse(container.dataset.units);
    // console.log(unitData);
    
    addButton.addEventListener('click', function(){
        
        // querySelectorでクラス名を参照する場合は.を前に付ける
        let ingredientCount = document.querySelectorAll('.ingredient-item').length;
        // 現在のフォームの数に1を足す
        // 今表示されている手順の次の手順を足すため
        ingredientCount++;
        console.log(`addFormCount:${ingredientCount}`);
        
        // 新しい'ingredient-item'のdivタグ
        const newItem = document.createElement('div');
        newItem.classList.add('ingredient-item', 'px-4', 'rounded-lg', 'border', 'border-gray-300');
        newItem.id = `ingredient-item${ingredientCount}`;
        
        const newFlexItem = document.createElement('div');
        newFlexItem.classList.add('flex', 'pt-4');
        
        const newTitle = document.createElement('h3');
        newTitle.classList.add('ingredient_title', 'font-semibold', 'pt-2');
        newTitle.textContent = `材料${ingredientCount}`;
        
        const newPadding = document.createElement('div');
        newPadding.classList.add('px-2');
        
        // 新しい削除ボタン
        const deleteButton = document.createElement('button');
        deleteButton.type = 'button';
        deleteButton.classList.add('ingredient-delete-button', 'my-btn');
        deleteButton.dataset.id = `${ingredientCount}`;
        deleteButton.textContent = '削除';
        
        // 削除ボタンがクリックされたときの処理
        deleteButton.addEventListener('click', function(){
            // 新しく追加された手順項目のid属性から手順番号を抽出している
            const currentIngredientCount = parseInt(newItem.id.match(/\d+/)[0]);
            
            // 手順番号を動的に変更
            ingredientCount--;
            
            console.log(`currentCount:${currentIngredientCount}`);
            console.log(`ingredientCount:${ingredientCount}`);
            
            // 手順項目を削除
            container.removeChild(newItem);
            
            // 手順番号を振りなおす
            renumberIngredientItems(currentIngredientCount);
        });
        
        const newPaddingItem = document.createElement('div');
        newPaddingItem.classList.add('px-4', 'pb-4');
        
        // 新しい'ingredient_category'のdivタグ
        const newIngredientCategory = document.createElement('div');
        newIngredientCategory.classList.add('ingredient_category', 'py-1', 'px-8');
        
        // 新しいラベル
        const ingredientCategoryLabel = document.createElement('label');
        ingredientCategoryLabel.htmlFor = `ingredient_category${ingredientCount}`;
        ingredientCategoryLabel.textContent = "カテゴリを選択：";
        
        // 新しいselectタグ
        const ingredientCategorySelect = document.createElement('select');
        ingredientCategorySelect.name = `ingredient[${ingredientCount}][ingredient_category_id]`;
        ingredientCategorySelect.id = `select_ingredient_category${ingredientCount}`;
        
        // カテゴリのオプションを追加
        const ingredientCategoryOption = document.createElement('option');
        ingredientCategoryOption.value = '';
        ingredientCategoryOption.textContent = 'カテゴリを選んでください';
        ingredientCategorySelect.appendChild(ingredientCategoryOption);
        
        // カテゴリデータを元にオプションを追加
        for (const category of ingredientCategoryData) {
            const ingredientCategoryOption = document.createElement('option');
            ingredientCategoryOption.value = category.id;
            ingredientCategoryOption.textContent = category.category;
            ingredientCategorySelect.appendChild(ingredientCategoryOption);
        }
        
        // 新しいバリデーションエラー表示タグ
        // const newIngredientCategoryValidation = document.createElement('p');
        // newIngredientCategoryValidation.className = 'ingredient_category_error';
        // newIngredientCategoryValidation.setAttribute('style', "color:red");
        
        // 新しい'ingredient_name'のdivタグ
        const newIngredientName = document.createElement('div');
        newIngredientName.classList.add('ingredient_name', 'py-1', 'px-8');
        
        // 新しいラベル
        const ingredientNameLabel = document.createElement('label');
        ingredientNameLabel.htmlFor = `ingredient_name${ingredientCount}`;
        ingredientNameLabel.textContent = "材料名：";
        
        const ingredientNameInput = document.createElement('input');
        ingredientNameInput.type = "text";
        ingredientNameInput.name = `ingredient[${ingredientCount}][name]`;
        ingredientNameInput.id = `input_ingredient_name${ingredientCount}`;
        ingredientNameInput.placeholder = "材料を入力";
        
        // 新しいバリデーションエラー表示タグ
        // const newIngredientNameValidation = document.createElement('p');
        // newIngredientNameValidation.className = 'ingredient_error';
        // newIngredientNameValidation.setAttribute('style', "color:red");
        
        const newFlex = document.createElement('div');
        newFlex.classList.add('flex', 'py-1', 'px-8');
        
        // 新しい'ingredient_quantity'のdivタグ
        const newIngredientQuantity = document.createElement('div');
        newIngredientQuantity.classList.add('ingredient_quantity');
        
        // 新しいラベル
        const ingredientQuantityLabel = document.createElement('label');
        ingredientQuantityLabel.htmlFor = `ingredient_quantity${ingredientCount}`;
        ingredientQuantityLabel.textContent = "量：";
        
        const ingredientQuantityInput = document.createElement('input');
        ingredientQuantityInput.type = "text";
        ingredientQuantityInput.name = `ingredient_recipe[${ingredientCount}][quantity]`;
        ingredientQuantityInput.id = `input_ingredient_quantity${ingredientCount}`;
        ingredientQuantityInput.placeholder = "量を入力";
        ingredientQuantityInput.min = 1;
        ingredientQuantityInput.max = 99999999;
        
        // 新しいバリデーションエラー表示タグ
        // const newIngredientQuantityValidation = document.createElement('p');
        // newIngredientQuantityValidation.className = 'ingredient_quantity_error';
        // newIngredientQuantityValidation.setAttribute('style', "color:red");
        
        // 新しい'ingredient_unit'のdivタグ
        const newIngredientUnit = document.createElement('div');
        newIngredientUnit.classList.add('ingredient_unit', 'pl-2');
        
        // 新しいselectタグ
        const ingredientUnitSelect = document.createElement('select');
        ingredientUnitSelect.name = `ingredient_recipe[${ingredientCount}][unit_id]`;
        ingredientUnitSelect.id = `select_ingredient_unit${ingredientCount}`;
        
        // カテゴリのオプションを追加
        const ingredientUnitOption = document.createElement('option');
        ingredientUnitOption.value = '';
        ingredientUnitOption.textContent = '単位を選んでください';
        ingredientUnitSelect.appendChild(ingredientUnitOption);
        
        // カテゴリデータを元にオプションを追加
        for (const unit of unitData) {
            const ingredientUnitOption = document.createElement('option');
            ingredientUnitOption.value = unit.id;
            ingredientUnitOption.textContent = unit.name;
            ingredientUnitSelect.appendChild(ingredientUnitOption);
        }
        
        // 新しいバリデーションエラー表示タグ
        // const newIngredientUnitValidation = document.createElement('p');
        // newIngredientUnitValidation.className = 'unit_error';
        // newIngredientUnitValidation.setAttribute('style', "color:red");
        
        newPadding.appendChild(deleteButton);
        
        newFlexItem.appendChild(newTitle);
        newFlexItem.appendChild(newPadding);
        
        newIngredientCategory.appendChild(ingredientCategoryLabel);
        newIngredientCategory.appendChild(ingredientCategorySelect);
        // newIngredientCategory.appendChild(newIngredientCategoryValidation);
        
        newIngredientName.appendChild(ingredientNameLabel);
        newIngredientName.appendChild(ingredientNameInput);
        // newIngredientName.appendChild(newIngredientNameValidation);
        
        newIngredientQuantity.appendChild(ingredientQuantityLabel);
        newIngredientQuantity.appendChild(ingredientQuantityInput);
        // newIngredientQuantity.appendChild(newIngredientQuantityValidation);
        
        newIngredientUnit.appendChild(ingredientUnitSelect);
        // newIngredientUnit.appendChild(newIngredientUnitValidation);
        
        newFlex.appendChild(newIngredientQuantity);
        newFlex.appendChild(newIngredientUnit);
        
        newPaddingItem.appendChild(newIngredientCategory);
        newPaddingItem.appendChild(newIngredientName);
        newPaddingItem.appendChild(newFlex);
        
        newItem.appendChild(newFlexItem);
        newItem.appendChild(newPaddingItem);
        
        container.appendChild(newItem);
    });
    
    function renumberIngredientItems(startIndex) {
        let ingredientCount = document.querySelectorAll('.ingredient-item').length;
        console.log(`renumber/ingredientCount:${ingredientCount}`);
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
                // const ingredientUnitLabel = ingredientItem.querySelector(`label[for="ingredient_unit${i}"]`);
                // console.log(ingredientUnitLabel);
                // ingredientUnitLabel.htmlFor = `ingredient_unit${i - 1}`;
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