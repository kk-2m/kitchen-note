document.addEventListener('DOMContentLoaded', function () {
    const addButton = document.getElementById('add-ingredient');
    const container = document.getElementById('ingredient-container');
    
    addButton.addEventListener('click', function(){
        
        let formCount = document.querySelectorAll('textarea.procedures').length;
        // 現在のフォームの数に1を足す
        // 今表示されている手順の次の手順を足すため
        formCount++;
        console.log(`addFormCount:${formCount}`);
        
        // 新しい'procedure-item'のdivタグ
        const newProcedure = document.createElement('div');
        newProcedure.classList.add('procedure-item');
        newProcedure.id = `procedure${formCount}`;
        
        // 新しい'textarea'のdivタグ
        const newTextarea = document.createElement('div');
        newTextarea.classList.add('textarea');
        
        // 新しいラベル
        const label = document.createElement('label');
        label.htmlFor = `procedure${formCount}`;
        label.textContent = `手順${formCount}：`;
        
        // 新しいテキストエリア
        const textarea = document.createElement('textarea');
        textarea.name = `procedure[${formCount}][body]`;
        textarea.rows = 4;
        textarea.cols = 40;
        textarea.className = 'procedures';
        textarea.id = `form${formCount}`;
        textarea.placeholder = '例）ケトルで沸かしたお湯を注ぎ、3分待つ。';
        
        // 新しいバリデーションエラー表示タグ
        const newValidation = document.createElement('p');
        newValidation.className = 'procedure_error';
        newValidation.setAttribute('style', "color:red");
        
        // 新しい削除ボタン
        const deleteButton = document.createElement('button');
        deleteButton.type = 'button';
        deleteButton.classList.add('delete-button');
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
        
        newTextarea.appendChild(label);
        newTextarea.appendChild(textarea);
        newTextarea.appendChild(document.createElement('br'));
        
        newProcedure.appendChild(newTextarea);
        newProcedure.appendChild(newValidation);
        newProcedure.appendChild(deleteButton);
        
        
        container.appendChild(newProcedure);
    });
    
    function renumberProcedureItems(startIndex) {
        let formCount = document.querySelectorAll('textarea.procedures').length;
        for (let i = startIndex; i <= formCount + 1; i++) {
            const procedureItem = document.getElementById(`procedure${i}`);
            if (procedureItem) {
                procedureItem.id = `procedure${i - 1}`;
                const label = procedureItem.querySelector('label');
                label.htmlFor = `procedure${i - 1}`;
                label.textContent = `手順${i - 1}：`;
                const textarea = procedureItem.querySelector('textarea');
                textarea.name = `procedure[${i - 1}][body]`;
                textarea.id = `form${i - 1}`;
                const deleteButton = procedureItem.querySelector('.delete-button');
                deleteButton.dataset.id = i - 1;
            }
        }
    }
    
});