var gap_v = 15;
var gap_h = 7;
var oldgap;

function replace_node(node, node1, node2, binding) {
	var div = document.getElementById(node);
	var div1 = document.getElementById(node1);
	var div2 = document.getElementById(node2);
	var binding = document.getElementById(binding);
	div.style.visibility="visible";
	div1.style.visibility="visible";
	div2.style.visibility="visible";
	binding.style.visibility="visible";
	if (!div2) {
		oldgap_tmp = oldgap;
	} else {
		oldgap_tmp = ( div2.offsetTop - div.offsetTop ) - div.offsetHeight;
		oldgap = oldgap_tmp;
	}
	div1.style.top = ( div.offsetHeight + (oldgap_tmp/2) ) - ( div1.offsetHeight/2 ) + div.offsetTop;
	div1.style.left = div.offsetLeft + div.offsetWidth + (2*gap_h);
	if (div2) {
		binding.style.top = div.offsetTop + (div.offsetHeight/2);
		binding.style.left = div.offsetLeft + div.offsetWidth + gap_h - (binding.offsetWidth/2);
		binding.style.height = div2.offsetTop - div.offsetTop;
	}
}

function replace_node_v(node, node1) {
	var div = document.getElementById(node);
	var div1 = document.getElementById(node1);
	var f = div.offsetHeight + gap_v;
	div1.style.top = div.offsetTop + f;
	div1.style.left = div.offsetLeft;
}
