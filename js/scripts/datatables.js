  
   function initDatatables() {
	   $('.datatable').DataTable({
	            processing: true,
	            serverSide: true,
	            ajax: '{{ route('departments.serverSide') }}'
	    });
	}