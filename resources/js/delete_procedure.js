document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('procedure-container');
    
    const deleteButtons = document.querySelectorAll('.procedure-delete-button');

    deleteButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            // buttonのdata_idを抜き出す
            const dataId = button.getAttribute('data-id');
            const procedureItem = document.getElementById(`procedure${dataId}`);
            
            if (procedureItem) {
                // 手順項目を削除
                container.removeChild(procedureItem);
                // 手順番号を振りなおす
                renumberProcedureItems(dataId);
            }
        });
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