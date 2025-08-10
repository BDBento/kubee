jQuery(function ($) {
  // só atua na listagem padrão do WP (Tabela de posts)
  const $tbody = $('#the-list'); // corpo da tabela da listagem
  if (!$tbody.length) return;

  $tbody.sortable({
    items: 'tr.type-planos',
    cursor: 'move',
    axis: 'y',
    containment: 'parent',
    helper: function(e, ui){
      ui.children().each(function(){ $(this).width($(this).width()); });
      return ui;
    },
    update: function(){
      // coleta os IDs dos posts na nova ordem
      const order = $tbody.find('tr.type-planos').map(function(){
        return parseInt($(this).attr('id').replace('post-',''), 10);
      }).get();

      $.post(KubeePlanosOrder.ajax, {
        action: 'kubee_sort_planos',
        nonce: KubeePlanosOrder.nonce,
        order: order
      });
    }
  });
});
