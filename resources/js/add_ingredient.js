document.addEventListener('DOMContentLoaded', function () {
    const addButton = document.getElementById('add-ingredient');
    const container = document.getElementById('ingredient-container');

    
    addButton.addEventListener('click', function(){
        // 新しいラベル
        const newLabel = document.createElement('label');
        const formCount = document.querySelector('input').length + 1;
        // newLabel.setAttribute('for', `category${formCount}`)
        // newLabel.textContent = `手順${formCount}：`;
        
        // 新しい入力フォーム
        const newForm = document.createElement('input');
        newForm.type = 'text';
        newForm.name = `ingredient[name${formCount}]`;
        newForm.id = `category${formCount}`;
        newForm.placeholder = '材料を入力してください'
        
        // ラベルをコンテナに追加
        // container.appendChild(newLabel);
        
        // テキストエリアをコンテナに追加
        container.appendChild(newForm);
    });
});