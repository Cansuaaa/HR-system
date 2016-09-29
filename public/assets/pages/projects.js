var selectedId = [];
var departmentAll=[];
var createdBy;
var Names=[];
var Id=[];

(function( $ ) {
	'use strict';

	var EditableTable = {

		options: {
			addButton: '#addToTable',
			table: '#datatable-editable',
			dialog: {
				wrapper: '#dialog',
				cancelButton: '#dialogCancel',
				confirmButton: '#dialogConfirm',
			}
		},

		initialize: function() {
			this
				.setVars()
				.build()
				.events();
		},

		setVars: function() {
			this.$table	= $( this.options.table );
			this.$addButton	= $( this.options.addButton );

			// dialog
			this.dialog	= {};
			this.dialog.$wrapper = $( this.options.dialog.wrapper );
			this.dialog.$cancel = $( this.options.dialog.cancelButton );
			this.dialog.$confirm = $( this.options.dialog.confirmButton );

			return this;
		},

		build: function() {
			this.datatable = this.$table.DataTable({
				aoColumns: [
					null,
					null,
					null,
					null,
					{ "bSortable": false }
				],
			});
			window.dt = this.datatable;

			return this;
		},

		events: function() {
			var _self = this;
			this.$table.on('click', 'a.save-row', function( e ) {
				e.preventDefault();

				_self.rowSave( $(this).closest( 'tr' ) );
			})
				.on('click', 'a.cancel-row', function( e ) {
					e.preventDefault();

					_self.rowCancel( $(this).closest( 'tr' ) );
				})
				.on('click', 'a.edit-row', function( e ) {
					e.preventDefault();

					_self.rowEdit( $(this).closest( 'tr' ) );
				})
				.on( 'click', 'a.remove-row', function( e ) {
					e.preventDefault();

					var $row = $(this).closest( 'tr' );

					$.magnificPopup.open({
						items: {
							src: _self.options.dialog.wrapper,
							type: 'inline'
						},
						preloader: false,
						modal: true,
						callbacks: {
							change: function() {
								_self.dialog.$confirm.on( 'click', function( e ) {
									e.preventDefault();

									_self.rowRemove( $row );
									$.magnificPopup.close();
								});
							},
							close: function() {
								_self.dialog.$confirm.off( 'click' );
							}
						}
					});
				});

			this.$addButton.on( 'click', function(e) {
				e.preventDefault();
				_self.rowAdd();
			});

			this.dialog.$cancel.on( 'click', function( e ) {
				e.preventDefault();
				$.magnificPopup.close();
			});

			return this;
		},

		// ==========================================================================================
		// ROW FUNCTIONS
		// ==========================================================================================
		rowAdd: function() {
			this.$addButton.attr({ 'disabled': 'disabled' });
			var actions,
				data,
				$row;

			actions = [
				'<a href="#" class="hidden on-editing save-row"><i class="fa fa-save"></i></a>',
				'<a href="#" class="hidden on-editing cancel-row"><i class="fa fa-times"></i></a>',
				'<a href="#" class="on-default edit-row"><i class="fa fa-pencil"></i></a>',
				'<a href="#" class="on-default remove-row"><i class="fa fa-trash-o"></i></a>'
			].join(' ');

			data = this.datatable.row.add(['','','','',actions ]);
			$row = this.datatable.row( data[0] ).nodes().to$();

			$row
				.addClass( 'adding' )
				.find( 'td:last' )
				.addClass( 'actions' );

			this.rowEdit( $row );

			this.datatable.order([0,'asc']).draw(); // always show fields
		},

		rowCancel: function( $row ) {
			var _self = this,
				$actions,
				i,
				data;

			if ( $row.hasClass('adding') ) {
				this.rowRemove( $row );
			} else {

				data = this.datatable.row( $row.get(0) ).data();
				this.datatable.row( $row.get(0) ).data( data );

				$actions = $row.find('td.actions');
				if ( $actions.get(0) ) {
					this.rowSetActionsDefault( $row );
				}

				this.datatable.draw();
			}
		},

		rowEdit: function( $row ) {
			var _self = this,
				data;

			data = this.datatable.row( $row.get(0) ).data();
			createdBy=data[3];
			var rowLength = data.length - 3;
			$row.children('td').each(function( i ) {
				var $this = $( this );
				if (i !== rowLength + 1)
				{
					if (i !== rowLength)
					{
						if ($this.hasClass('actions'))
						{
							_self.rowSetActionsEditing($row);
						}
						else
						{
							$this.html('<input type="text" class="form-control input-block" value="' + data[i] + '"/>');
						}
					}
					else
					{
						$('.deps').each(function(i){
							Id[i]=$(this).attr('id');
							Names[i]=$(this).text();
							departmentAll.push([Id[i],Names[i]]);
						});

						var rowData = data[i].replace(/(<([^>]+)>)/ig,":");
						var regex=/:(.*?):/g;
						var currentDepartments=[];
						currentDepartments=rowData.match(regex);
						if(currentDepartments!=null)
						{
							for(var j=0; j<currentDepartments.length; j++)
							{
								currentDepartments[j]=currentDepartments[j].replace(/:/g,"");
							}
						}


						if(currentDepartments!=null)
						{
							var rowForHtml="<select id='type' multiple>";
							Names.forEach(function (index) {
								if(currentDepartments.includes(index))
								{
									rowForHtml=rowForHtml+"<option value='" + Id[Names.indexOf(index)] + "' selected> "+ index +"</option>" ;
									selectedId[Names.indexOf(index)]=Id[Names.indexOf(index)];
								}
								else
								{
									rowForHtml=rowForHtml+"<option value='" + Id[Names.indexOf(index)] + "' > "+ index +"</option>" ;
								}
							})
						}
						else
						{
							var rowForHtml="<select id='add' multiple>";
							Names.forEach(function (index) {
								rowForHtml=rowForHtml+"<option value='" + Id[Names.indexOf(index)] + "' > "+ index +"</option>" ;
							})
						}

						rowForHtml=rowForHtml + " </select>";
						$this.html(rowForHtml);

						$("#type").change(function() {
							selectedId=$(this).val();
							console.log(selectedId);
						});
						$(function () {
							$(document).on("change", "#add", function () {
								selectedId=$(this).val();
								console.log(selectedId);
							})
						})

					}
				}
			});
		},

		rowSave: function( $row ) {
			var _self     = this,
				$actions,
				values    = [];
			var move;
			if ( $row.hasClass( 'adding' ) ) {
				move="add";
				createdBy="CurrentLoggedInUser";
				this.$addButton.removeAttr( 'disabled' );
				$row.removeClass( 'adding' );
			}
			else
			{
				move="edit";
			}

			values = $row.find('td').map(function()
			{
				var $this = $(this);

				if ( $this.hasClass('actions') ) {
					_self.rowSetActionsDefault( $row );
					return _self.datatable.cell( this ).data();
				} else {
					return $.trim( $this.find('input').val() );
				}
			});

			var rowForHtml="";
			var idForPHP=[];
			var idForPHPIndex=0;
			Id.forEach(function(index) {
				if(selectedId.includes(index))
				{
					rowForHtml=rowForHtml+" <span id=" + index + ">" + Names[Id.indexOf(index)] + "</span>";
					idForPHP[idForPHPIndex]=index;
					idForPHPIndex++;
				}
			});
			values[2]=rowForHtml;
			values[3]=createdBy;

			this.datatable.row( $row.get(0) ).data( values );

			$actions = $row.find('td.actions');
			if ( $actions.get(0) )
			{
				this.rowSetActionsDefault($row);
			};

			var id = $row.closest('tr').attr('id');
			var url = "/ajax/projectsCRUD";
			$.ajax({
				type: "POST",
				url: url,
				data: { id : id , name : values[0] , action : move, description:values[1], departmentId: idForPHP, createdBy:values[3]},
				success: function (data)
				{
				}
			});
			this.datatable.draw();
		},

		rowRemove: function( $row ) {
			var move;
			if ( $row.hasClass('adding') ) {
				move = "add";
				this.$addButton.removeAttr( 'disabled' );
			}
			var id = $row.closest('tr').attr('id');
			if(move!="add")
			{
				move="delete";
				var url = "/ajax/projectsCRUD";
				$.ajax({
					type: "POST",
					url: url,
					data: { id : id , name : "" , action : move},
					dataType: 'json',
					success: function (data)
					{

					}
				});
			}

			this.datatable.row( $row.get(0) ).remove().draw();
		},

		rowSetActionsEditing: function( $row ) {
			$row.find( '.on-editing' ).removeClass( 'hidden' );
			$row.find( '.on-default' ).addClass( 'hidden' );
		},

		rowSetActionsDefault: function( $row ) {
			$row.find( '.on-editing' ).addClass( 'hidden' );
			$row.find( '.on-default' ).removeClass( 'hidden' );
		}

	};

	$(function() {
		EditableTable.initialize();
	});

}).apply( this, [ jQuery ]);