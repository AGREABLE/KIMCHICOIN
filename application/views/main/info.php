
		<div class="row">
			<form class="form-horizontal" role="form" method="post" action="/<?php echo $cname?>/update">
				<input type="hidden" name="idx" value="<?php echo $one->idx?>" />
				<div class="col-lg-12 col-md-12">
					<div class="col-md-12">
						<section class="widget widget-info clear-box">
							<header>
								<h4>
									기본정보 입력
								</h4>
							</header>
							<div class="widget-body">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group clear-box">
											<label class="col-xs-4 widget-info-field" for="title">이름<span class="text-danger">(필수)</span></label>
											<div class="col-xs-7 widget-info-value">
												<input type="text" id="name" name="name" class="form-control" placeholder="직원 이름을 입력해주세요." value="<?php echo $one->name?>" required>
											</div>
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-md-12">
										<div class="form-group clear-box">
											<label class="col-xs-4 widget-info-field" for="title">아이디<span class="text-danger">(필수)</span></label>
											<div class="col-xs-7 widget-info-value">
												<input type="text"class="form-control" placeholder="직원 아이디로 사용할 이메일을 입력해주세요." value="<?php echo $one->email?>" readonly>
											</div>
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-md-12">
										<div class="form-group clear-box">
											<label class="col-xs-4 widget-info-field" for="title">비밀번호<span class="text-danger">(필수)</span></label>
											<div class="col-xs-7 widget-info-value">
												<input type="password" id="pwd" name="pwd" class="form-control" placeholder="변경할 비밀번호를 입력해주세요." >
											</div>
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-md-12">
										<div class="form-group clear-box">
											<label class="col-xs-4 widget-info-field" for="title">연락처</label>
											<div class="col-xs-7 widget-info-value">
												<input type="text" id="phone_number" name="phone_number" class="form-control" placeholder="직원 연락처를 입력해주세요." value="<?php echo $one->phone_number?>" >
											</div>
										</div>
									</div>
								</div>
							</div>
						</section>
					</div>
				</div>
				
								
				<div class="col-md-12 mt">
					<div class="col-md-6">
					</div>
					
					<div class="col-md-6">
						<div class="pull-right">
							<button class="btn btn-primary">수정하기</button>
							<a class="btn btn-default btn-back">취소</a>
						</div>
					</div>
				</div>
				
			</form>
		</div>