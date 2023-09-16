document.addEventListener('DOMContentLoaded', function () {
    const addButton = document.getElementById('add-procedure');
    const container = document.getElementById('procedure-container');

    
    addButton.addEventListener('click', function(){
        // 新しいラベル
        const newLabel = document.createElement('label');
        const formCount = document.querySelector('textarea').length + 1;
        // newLabel.setAttribute('for', `category${formCount}`)
        // newLabel.textContent = `手順${formCount}：`;
        
        // 新しいテキストエリア
        const newTextarea = document.createElement('textarea');
        newTextarea.name = `procedures[body${formCount}]`;
        newTextarea.className = 'procedures';
        newTextarea.id = `category${formCount}`;
        newTextarea.placeholder = '例）ケトルで沸かしたお湯を注ぎ、3分待つ。'
        
        // ラベルをコンテナに追加
        // container.appendChild(newLabel);
        
        // テキストエリアをコンテナに追加
        container.appendChild(newTextarea);
  });
});