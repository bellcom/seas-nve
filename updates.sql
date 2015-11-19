alter table TiltagDetail
modify `belysningstiltag` enum('','armatur','led_i_eksisterende_armatur','ny_indsats_i_arm','andet_se_noter') COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:TiltagType)',

alter table TiltagDetail
modify `styring` enum('','pir_i_afbryder','pir_on_off','pir_dgs','skumringsrelae','andet_se_noter') COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:StyringType)';
