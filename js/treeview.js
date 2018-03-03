	$(function () {

		var defaultData = [
			{
				text: '<h2>Exams Category</h2> <p>26.56 GB</p>'
				, href: '#parent1'
				, tags: ['12']
				, nodes: [
					{
						text: '<h3>Introduction</h3'
						, href: '#child1'
						, tags: ['2']
						, nodes: [
							{
								text: '<h3>Grandchild 1</h3'
								, href: '#grandchild1'
								, tags: ['0']
                  }
							, {
								text: '<h3>Grandchild 2</h3'
								, href: '#grandchild2'
								, tags: ['0']
                  }
                ]
              }
					, {
						text: '<h3>Important Information and Rules</h3'
						, href: '#child2'
						, tags: ['2']
						, nodes: [
							{
								text: '<h3>Grandchild 1</h3'
								, href: '#grandchild1'
								, tags: ['0']
								, nodes: [
									{
										text: '<h3>Grandchild 1</h3'
										, href: '#grandchild1'
										, tags: ['0']
                  }
									, {
										text: '<h3>Grandchild 2</h3'
										, href: '#grandchild2'
										, tags: ['0']
                  }
                ]
                  }
							, {
								text: '<h3>Grandchild 2</h3'
								, href: '#grandchild2'
								, tags: ['0']
                  }
                ]
              }
					, {
						text: '<h3>Introduction</h3'
						, href: '#child1'
						, tags: ['2']
						, nodes: [
							{
								text: '<h3>Grandchild 1</h3'
								, href: '#grandchild1'
								, tags: ['0']
                  }
							, {
								text: '<h3>Grandchild 2</h3'
								, href: '#grandchild2'
								, tags: ['0']
                  }
                ]
              }
					, {
						text: '<h3>Important Information and Rules</h3'
						, href: '#child2'
						, tags: ['2']
						, nodes: [
							{
								text: '<h3>Grandchild 1</h3'
								, href: '#grandchild1'
								, tags: ['0']
								, nodes: [
									{
										text: '<h3>Grandchild 1</h3'
										, href: '#grandchild1'
										, tags: ['0']
                  }
									, {
										text: '<h3>Grandchild 2</h3'
										, href: '#grandchild2'
										, tags: ['0']
                  }
                ]
                  }
							, {
								text: '<h3>Grandchild 2</h3'
								, href: '#grandchild2'
								, tags: ['0']
                  }
                ]
              }
					, {
						text: '<h3>Introduction</h3'
						, href: '#child1'
						, tags: ['2']
						, nodes: [
							{
								text: '<h3>Grandchild 1</h3'
								, href: '#grandchild1'
								, tags: ['0']
                  }
							, {
								text: '<h3>Grandchild 2</h3'
								, href: '#grandchild2'
								, tags: ['0']
                  }
                ]
              }
					, {
						text: '<h3>Important Information and Rules</h3'
						, href: '#child2'
						, tags: ['2']
						, nodes: [
							{
								text: '<h3>Grandchild 1</h3'
								, href: '#grandchild1'
								, tags: ['0']
								, nodes: [
									{
										text: '<h3>Grandchild 1</h3'
										, href: '#grandchild1'
										, tags: ['0']
                  }
									, {
										text: '<h3>Grandchild 2</h3'
										, href: '#grandchild2'
										, tags: ['0']
                  }
                ]
                  }
							, {
								text: '<h3>Grandchild 2</h3'
								, href: '#grandchild2'
								, tags: ['0']
                  }
                ]
              }
					, {
						text: '<h3>Introduction</h3'
						, href: '#child1'
						, tags: ['2']
						, nodes: [
							{
								text: '<h3>Grandchild 1</h3'
								, href: '#grandchild1'
								, tags: ['0']
                  }
							, {
								text: '<h3>Grandchild 2</h3'
								, href: '#grandchild2'
								, tags: ['0']
                  }
                ]
              }
					, {
						text: '<h3>Important Information and Rules</h3'
						, href: '#child2'
						, tags: ['2']
						, nodes: [
							{
								text: '<h3>Grandchild 1</h3'
								, href: '#grandchild1'
								, tags: ['0']
								, nodes: [
									{
										text: '<h3>Grandchild 1</h3'
										, href: '#grandchild1'
										, tags: ['0']
                  }
									, {
										text: '<h3>Grandchild 2</h3'
										, href: '#grandchild2'
										, tags: ['0']
                  }
                ]
                  }
							, {
								text: '<h3>Grandchild 2</h3'
								, href: '#grandchild2'
								, tags: ['0']
                  }
                ]
              }
					, {
						text: '<h3>Introduction</h3'
						, href: '#child1'
						, tags: ['2']
						, nodes: [
							{
								text: '<h3>Grandchild 1</h3'
								, href: '#grandchild1'
								, tags: ['0']
                  }
							, {
								text: '<h3>Grandchild 2</h3'
								, href: '#grandchild2'
								, tags: ['0']
                  }
                ]
              }
					, {
						text: '<h3>Important Information and Rules</h3'
						, href: '#child2'
						, tags: ['2']
						, nodes: [
							{
								text: '<h3>Grandchild 1</h3'
								, href: '#grandchild1'
								, tags: ['0']
								, nodes: [
									{
										text: '<h3>Grandchild 1</h3'
										, href: '#grandchild1'
										, tags: ['0']
                  }
									, {
										text: '<h3>Grandchild 2</h3'
										, href: '#grandchild2'
										, tags: ['0']
                  }
                ]
                  }
							, {
								text: '<h3>Grandchild 2</h3'
								, href: '#grandchild2'
								, tags: ['0']
                  }
                ]
              }
					, {
						text: '<h3>Introduction</h3'
						, href: '#child1'
						, tags: ['2']
						, nodes: [
							{
								text: '<h3>Grandchild 1</h3'
								, href: '#grandchild1'
								, tags: ['0']
                  }
							, {
								text: '<h3>Grandchild 2</h3'
								, href: '#grandchild2'
								, tags: ['0']
                  }
                ]
              }
					, {
						text: '<h3>Important Information and Rules</h3'
						, href: '#child2'
						, tags: ['2']
						, nodes: [
							{
								text: '<h3>Grandchild 1</h3'
								, href: '#grandchild1'
								, tags: ['0']
								, nodes: [
									{
										text: '<h3>Grandchild 1</h3'
										, href: '#grandchild1'
										, tags: ['0']
                  }
									, {
										text: '<h3>Grandchild 2</h3'
										, href: '#grandchild2'
										, tags: ['0']
                  }
                ]
                  }
							, {
								text: '<h3>Grandchild 2</h3'
								, href: '#grandchild2'
								, tags: ['0']
                  }
                ]
              }
					, {
						text: '<h3>Introduction</h3'
						, href: '#child1'
						, tags: ['2']
						, nodes: [
							{
								text: '<h3>Grandchild 1</h3'
								, href: '#grandchild1'
								, tags: ['0']
                  }
							, {
								text: '<h3>Grandchild 2</h3'
								, href: '#grandchild2'
								, tags: ['0']
                  }
                ]
              }
					, {
						text: '<h3>Important Information and Rules</h3'
						, href: '#child2'
						, tags: ['2']
						, nodes: [
							{
								text: '<h3>Grandchild 1</h3'
								, href: '#grandchild1'
								, tags: ['0']
								, nodes: [
									{
										text: '<h3>Grandchild 1</h3'
										, href: '#grandchild1'
										, tags: ['0']
                  }
									, {
										text: '<h3>Grandchild 2</h3'
										, href: '#grandchild2'
										, tags: ['0']
                  }
                ]
                  }
							, {
								text: '<h3>Grandchild 2</h3'
								, href: '#grandchild2'
								, tags: ['0']
                  }
                ]
              }
					, {
						text: '<h3>Introduction</h3'
						, href: '#child1'
						, tags: ['2']
						, nodes: [
							{
								text: '<h3>Grandchild 1</h3'
								, href: '#grandchild1'
								, tags: ['0']
                  }
							, {
								text: '<h3>Grandchild 2</h3'
								, href: '#grandchild2'
								, tags: ['0']
                  }
                ]
              }
					, {
						text: '<h3>Important Information and Rules</h3'
						, href: '#child2'
						, tags: ['2']
						, nodes: [
							{
								text: '<h3>Grandchild 1</h3'
								, href: '#grandchild1'
								, tags: ['0']
								, nodes: [
									{
										text: '<h3>Grandchild 1</h3'
										, href: '#grandchild1'
										, tags: ['0']
                  }
									, {
										text: '<h3>Grandchild 2</h3'
										, href: '#grandchild2'
										, tags: ['0']
                  }
                ]
                  }
							, {
								text: '<h3>Grandchild 2</h3'
								, href: '#grandchild2'
								, tags: ['0']
                  }
                ]
              }
            ]
          }
        ];



		$('#treeview5').treeview({
			color: "#d8dcd9",
			backColor: "white",
			onhoverColor: "#fafcfc",
			borderColor: "none",
			highlightSelected: true,
			selectedColor: "#fafcfc",
			selectedBackColor: "#fafcfc",
			expandIcon: 'glyphicon icon-close iconcustom',
			collapseIcon: 'glyphicon icon-open iconcustom',
			nodeIcon: 'icon-file-article',
			data: defaultData
		});


	});