<!-- Info boxes -->
      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-plus-square"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Tổng số tin đăng</span>
              <span class="info-box-number"><?=$this->real_estate_model->_Count_All()?></span>
              
            </div>
            <div class="clearfix"></div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-calendar-times-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Tin đăng hết hạn</span>
              <span class="info-box-number"><?=$this->real_estate_model->_Count_Out_Date()?></span>
            </div><div class="clearfix"></div>
            <!-- /.info-box-content -->
          </div>
          
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-calendar-check-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Tin đăng trong ngày</span>
              <span class="info-box-number"><?=$this->real_estate_model->_Count_In_Date()?></span>
            </div><div class="clearfix"></div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-users"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Thành viên</span>
              <span class="info-box-number"><?=$this->ion_auth->users()->num_rows()?></span>
            </div><div class="clearfix"></div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
