var nestedSortables=[].slice.call(document.querySelectorAll(".nested-sortable"));nestedSortables&&Array.from(nestedSortables).forEach(function(e){new Sortable(e,{group:"nested",animation:150,fallbackOnBody:!0,swapThreshold:.65})});var nestedSortablesHandles=[].slice.call(document.querySelectorAll(".nested-sortable-handle"));nestedSortablesHandles&&Array.from(nestedSortablesHandles).forEach(function(e){new Sortable(e,{handle:".handle",group:"nested",animation:150,fallbackOnBody:!0,swapThreshold:.65})});