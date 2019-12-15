<label>URL</label><br />
<input id='di-anchor-link' type='text' onchange="if (this.value == '') $('#di-anchor-apply-btn').html('Remove Link'); else $('#di-anchor-apply-btn').html('Apply Link')">
<hr />
<input type="checkbox" id="di-anchor-new-tab">
<label for="di-anchor-new-tab">Open in New Tab</label><br />
<button id="di-anchor-apply-btn" onclick='ApplyLinkToSelection()'>Remove Link</button>