<div class="container" >
  <div class="page-header">
    <h1>건의사항</h1>
  </div>
<div class="row" id="help">

  <div class="col-xs-12">
      <table id="help_table" class="table ">
        <thead>
          <tr>
            <th>제목</th>
            <th>시간</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>어제</td>
            <td>삭제</td>
          </tr>
        </tbody>
      </table>
      <script>
      $(document).ready(function(){
        $('#help_table').DataTable({
          ordering:  false
        });
      });
      </script>
  </div>
</div>
</div>
