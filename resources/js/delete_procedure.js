document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('procedure-container');
    
    const deleteButtons = document.querySelectorAll('.procedure-delete-button');

    deleteButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            // buttonのdata_idを抜き出す
            const dataId = parseInt(button.getAttribute('data-id'));
            const procedureItem = document.getElementById(`procedure-item${dataId}`);
            
            if (procedureItem) {
                // 手順項目を削除
                container.removeChild(procedureItem);
                // 手順番号を振りなおす
                renumberProcedureItems(dataId);
            }
        });
    });
    
    function renumberProcedureItems(startIndex) {
        let formCount = document.querySelectorAll('.procedure-item').length;
        console.log(`renumber/ingredientCount:${typeof formCount}`);
        console.log(`startIndex:${typeof startIndex}`);
        console.log("Before loop");
        for (let i = startIndex + 1; i <= formCount + 1; i++) {
            console.log("enter");
            const procedureItem = document.getElementById(`procedure-item${i}`);
            console.log(procedureItem)
            if (procedureItem) {
                procedureItem.id = `procedure-item${i - 1}`;
                console.log(procedureItem);
                
                const label = procedureItem.querySelector('h3');
                label.textContent = `材料${i - 1}`;
                const textarea = procedureItem.querySelector('textarea');
                console.log(textarea);
                textarea.name = `procedure[${i - 1}][body]`;
                textarea.id = `form${i - 1}`;
                const deleteButton = procedureItem.querySelector('button.procedure-delete-button');
                console.log(deleteButton);
                deleteButton.dataset.id = i - 1;
            }
        }
        console.log("After loop");
    }
    
});