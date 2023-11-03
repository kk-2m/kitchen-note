document.addEventListener('DOMContentLoaded', function () {
    const addButton = document.getElementById('add-procedure');
    const container = document.getElementById('procedure-container');
    
    addButton.addEventListener('click', function(){
        
        let formCount = document.querySelectorAll('textarea.procedures').length;
        // 現在のフォームの数に1を足す
        // 今表示されている手順の次の手順を足すため
        formCount++;
        console.log(`addFormCount:${formCount}`);
        
        // 新しい'procedure-item'のdivタグ
        const newProcedure = document.createElement('div');
        newProcedure.classList.add('procedure-item', 'px-4', 'rounded-lg', 'border', 'border-gray-300');
        newProcedure.id = `procedure-item${formCount}`;
        
        const newFlexItem = document.createElement('div');
        newFlexItem.classList.add('flex', 'py-2');
        
        // 新しいラベル
        const label = document.createElement('h3');
        label.classList.add(`procedure${formCount}`, 'font-semibold', 'pt-2');
        label.textContent = `手順${formCount}`;
        
        const newPadding = document.createElement('div');
        newPadding.classList.add('px-2');
        
        // 新しい削除ボタン
        const deleteButton = document.createElement('button');
        deleteButton.type = 'button';
        deleteButton.classList.add('procedure-delete-button', 'my-btn');
        deleteButton.dataset.id = `${formCount}`;
        deleteButton.textContent = '削除';
        
        // 削除ボタンがクリックされたときの処理
        deleteButton.addEventListener('click', function(){
            // 新しく追加された手順項目のid属性から手順番号を抽出している
            const currentProcedureCount = parseInt(newProcedure.id.match(/\d+/)[0]);
            
            // 手順番号を動的に変更
            formCount--;
            
            console.log(`currentCount:${currentProcedureCount}`);
            console.log(`formCount:${formCount}`);
            
            // 手順項目を削除
            container.removeChild(newProcedure);
            
            // 手順番号を振りなおす
            renumberProcedureItems(currentProcedureCount);
        });
        
        // 新しい'textarea'のdivタグ
        const newTextarea = document.createElement('div');
        newTextarea.classList.add('textarea');
        
        // 新しいテキストエリア
        const textarea = document.createElement('textarea');
        textarea.name = `procedure[${formCount}][body]`;
        textarea.rows = 4;
        textarea.cols = 40;
        textarea.classList.add('procedures', 'w-full');
        textarea.id = `form${formCount}`;
        textarea.placeholder = '例）ケトルで沸かしたお湯を注ぎ、3分待つ。';
        
        // 新しいバリデーションエラー表示タグ
        // const newValidation = document.createElement('p');
        // newValidation.className = 'procedure_error';
        // newValidation.setAttribute('style', "color:red");
        
        newPadding.appendChild(deleteButton);
        
        newFlexItem.appendChild(label);
        newFlexItem.appendChild(newPadding);
        
        newTextarea.appendChild(textarea);
        newTextarea.appendChild(document.createElement('br'));
        
        newProcedure.appendChild(newFlexItem);
        newProcedure.appendChild(newTextarea);
        
        container.appendChild(newProcedure);
    });
    
    function renumberProcedureItems(startIndex) {
        let formCount = document.querySelectorAll('textarea.procedures').length;
        console.log(`renumber/ingredientCount:${formCount}`);
        console.log(`startIndex${startIndex}`)
        for (let i = startIndex + 1; i <= formCount + 1; i++) {
            const procedureItem = document.getElementById(`procedure-item${i}`);
            if (procedureItem) {
                procedureItem.id = `procedure-item${i - 1}`;
                const label = procedureItem.querySelector('h3');
                label.textContent = `材料${i - 1}`;
                const textarea = procedureItem.querySelector('textarea');
                textarea.name = `procedure[${i - 1}][body]`;
                textarea.id = `form${i - 1}`;
                const deleteButton = procedureItem.querySelector('.procedure-delete-button');
                deleteButton.dataset.id = i - 1;
            }
        }
    }
    
});