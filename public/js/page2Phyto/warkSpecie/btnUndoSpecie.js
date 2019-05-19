function btnUndoSpecie(updateURL, insertURL, grid, rowsOnPage, changedRows, cancel, variable){
    if (cancel.length > 0) {
        console.log('@@@cancel@')
        if (cancel[cancel.length - 1].do === "update") {//Отмена обновления
            variable.pressedUndoButton = true;
            updateSpecie(cancel[cancel.length - 1].data, updateURL, grid, rowsOnPage, changedRows, cancel, variable);
        }
        else if (cancel[cancel.length - 1].do === "delete") {
            cancelDeleteRowSpecie(cancel[cancel.length - 1].data, insertURL, grid, cancel, variable);
        }
        else if (cancel[cancel.length - 1].do === "insert") {
            variable.pressedUndoButton = true;
            grid.removeRow(cancel[cancel.length - 1].data.ID);
        }
    }
}