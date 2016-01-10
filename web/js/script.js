// <tr>
//     <td class="mdl-data-table__cell--non-numeric">
//         <input class="mdl-textfield__input mdl-textfield mdl-js-textfield" type="text" id="pass">
//     </td>
//     <td>
//         <input class="mdl-textfield__input mdl-textfield mdl-js-textfield" type="text" id="pass">
//     </td>
//     <td>
//         <input class="mdl-textfield__input mdl-textfield mdl-js-textfield" type="text" id="pass">
//     </td>
//     <td>
//         <input class="mdl-textfield__input mdl-textfield mdl-js-textfield" type="text" id="pass">
//     </td>
//     <td>
//         <input class="mdl-textfield__input mdl-textfield mdl-js-textfield" type="text" id="pass">
//     </td>
// </tr>
//  |
//  |   minify to
//  \/
var addedtemplate = $(' <tr> <td class="mdl-data-table__cell--non-numeric"> <input class="mdl-textfield__input mdl-textfield mdl-js-textfield" type="text" id="pass"> </td><td> <input class="mdl-textfield__input mdl-textfield mdl-js-textfield" type="text" id="pass"> </td><td> <input class="mdl-textfield__input mdl-textfield mdl-js-textfield" type="text" id="pass"> </td><td> <input class="mdl-textfield__input mdl-textfield mdl-js-textfield" type="text" id="pass"> </td><td> <input class="mdl-textfield__input mdl-textfield mdl-js-textfield" type="text" id="pass"> </td></tr>');

$(function () {
    $('.mdl-button-holder').on('click', '.add-field', function(event) {
        // $('tbody').append(addedtemplate);
        addedtemplate.appendTo('tbody');
        event.preventDefault();
        /* Act on the event */
    });
});
