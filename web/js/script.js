// <tr>
//     <td>
//         <div class="mdl-selectfield">
//             <label>Standard Select</label>
//             <select class="browser-default">
//                 <option value="" disabled selected>Kies je vak</option>
//                                     <option value="1">Burgerschap</option>
//                                     <option value="2">Programmeren</option>
//                                     <option value="3">Engels</option>
//                                     <option value="4">Loopbaanleren</option>
//                                     <option value="5">Ondernemendheid</option>
//                                     <option value="6">B-ict</option>
//                                     <option value="8">Projectles</option>
//                                     <option value="9">Sport</option>
//                                     <option value="10">Rekenen</option>
//                                     <option value="11">Oracle</option>
//                                 </select>
//         </div>
//     </td>
//     <td class="mdl-data-table__cell--non-numeric">
//         <input class="mdl-textfield__input mdl-textfield mdl-js-textfield" type="text" id="pass">
//     </td>
//     <td>
//         <input class="mdl-textfield__input mdl-textfield mdl-js-textfield" type="text" id="pass">
//     </td>
// </tr>
//  |
//  |   minify to
//  \/

$(function () {
    $('.mdl-button-holder').on('click', '.add-field', function(event) {
		addedtemplate = $('<tr> <td> <div class="mdl-selectfield"> <label>Standard Select</label> <select class="browser-default"> <option value="" disabled selected>Kies je vak</option> <option value="1">Burgerschap</option> <option value="2">Programmeren</option> <option value="3">Engels</option> <option value="4">Loopbaanleren</option> <option value="5">Ondernemendheid</option> <option value="6">B-ict</option> <option value="8">Projectles</option> <option value="9">Sport</option> <option value="10">Rekenen</option> <option value="11">Oracle</option> </select> </div></td><td class="mdl-data-table__cell--non-numeric"> <input class="mdl-textfield__input mdl-textfield mdl-js-textfield" type="text" id="pass"> </td><td> <input class="mdl-textfield__input mdl-textfield mdl-js-textfield" type="text" id="pass"> </td></tr>');
        // $('tbody').append(addedtemplate);
        addedtemplate.appendTo('tbody');
        event.preventDefault();
        /* Act on the event */
    });
});
