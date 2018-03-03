-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 24, 2016 at 11:44 AM
-- Server version: 5.7.16-0ubuntu0.16.04.1
-- PHP Version: 7.0.8-0ubuntu0.16.04.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `examdemoempty`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` int(10) UNSIGNED NOT NULL,
  `log_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `subject_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `causer_id` int(11) DEFAULT NULL,
  `causer_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `properties` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bookmarks`
--

CREATE TABLE `bookmarks` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `item_type` enum('questions') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'questions',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `couponcodes`
--

CREATE TABLE `couponcodes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `coupon_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `discount_type` enum('value','percent') COLLATE utf8_unicode_ci NOT NULL,
  `discount_value` decimal(10,2) NOT NULL,
  `minimum_bill` decimal(10,2) NOT NULL,
  `discount_maximum_amount` decimal(10,2) NOT NULL,
  `valid_from` date NOT NULL,
  `valid_to` date NOT NULL,
  `usage_limit` int(11) NOT NULL,
  `status` enum('Active','Inactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Active',
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `coupon_code_applicability` text COLLATE utf8_unicode_ci,
  `record_updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `couponcodes_usage`
--

CREATE TABLE `couponcodes_usage` (
  `id` bigint(20) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_type` varchar(50) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `item_cost` decimal(10,2) NOT NULL,
  `total_invoice_amount` decimal(10,2) NOT NULL,
  `discount_amount` decimal(10,2) NOT NULL,
  `coupon_id` bigint(20) UNSIGNED NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `emailtemplates`
--

CREATE TABLE `emailtemplates` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` enum('header','footer','content') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'content',
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `from_email` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `from_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `record_updated_by` int(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `emailtemplates`
--

INSERT INTO `emailtemplates` (`id`, `title`, `slug`, `type`, `subject`, `content`, `from_email`, `from_name`, `record_updated_by`, `created_at`, `updated_at`) VALUES
(1, 'header', 'header', 'header', 'header', '<p>Email</p>\r\n\r\n<div class="block"><!-- Start of preheader -->\r\n<table border="0" cellpadding="0" cellspacing="0" id="backgroundTable" style="width:100%">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<table align="center" border="0" cellpadding="0" cellspacing="0" class="devicewidth" style="width:580px">\r\n				<tbody><!-- Spacing -->\r\n					<tr>\r\n						<td>&nbsp;</td>\r\n					</tr>\r\n					<!-- Spacing -->\r\n					<tr>\r\n						<td>If you cannot read this email, please <a class="hlite" href="#" style="text-decoration: none; color: #0db9ea"> click here </a></td>\r\n					</tr>\r\n					<!-- Spacing -->\r\n					<tr>\r\n						<td>&nbsp;</td>\r\n					</tr>\r\n					<!-- Spacing -->\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n<!-- End of preheader --></div>\r\n\r\n<div class="block"><!-- start of header -->\r\n<table border="0" cellpadding="0" cellspacing="0" id="backgroundTable" style="width:100%">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<table align="center" border="0" cellpadding="0" cellspacing="0" class="devicewidth" style="border-bottom:1px solid #0db9ea; width:580px">\r\n				<tbody>\r\n					<tr>\r\n						<td><!-- logo -->\r\n						<table align="left" border="0" cellpadding="0" cellspacing="0" class="devicewidth" style="width:280px">\r\n							<tbody>\r\n								<tr>\r\n									<td>\r\n									<div class="imgpop"><a href="#"><img alt="logo" class="logo" src="http://conquerorslabs.com/exam2/public/uploads/settings/eKFhxlkXcMtX5xW.png" style="border:none; display:block; outline:none; text-decoration:none" /> </a></div>\r\n									</td>\r\n								</tr>\r\n							</tbody>\r\n						</table>\r\n						<!-- End of logo --><!-- menu -->\r\n\r\n						<table align="right" border="0" cellpadding="0" cellspacing="0" class="devicewidth" style="width:280px">\r\n							<tbody>\r\n								<tr>\r\n									<td><a href="#" style="text-decoration: none; color: #ffffff;">HOME </a> | <a href="#" style="text-decoration: none; color: #ffffff;"> ABOUT </a> | <a href="#" style="text-decoration: none; color: #ffffff;"> SHOP </a></td>\r\n									<td>&nbsp;</td>\r\n								</tr>\r\n							</tbody>\r\n						</table>\r\n						<!-- End of Menu --></td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n<!-- end of header --></div>\r\n', 'no@noemail.com', 'Test', 1, '2016-07-19 06:23:14', '2016-10-18 14:24:33'),
(2, 'footer', 'footer', 'footer', 'footer', '<div class="block">\r\n    <!-- Start of preheader -->\r\n    <table bgcolor="#f6f4f5" border="0" cellpadding="0" cellspacing="0" id="backgroundTable" st-sortable="postfooter" width="100%">\r\n        <tbody>\r\n            <tr>\r\n                <td width="100%">\r\n                    <table align="center" border="0" cellpadding="0" cellspacing="0" class="devicewidth" width="580">\r\n                        <tbody>\r\n                            <!-- Spacing -->\r\n                            <tr>\r\n                                <td height="5" width="100%">\r\n                                </td>\r\n                            </tr>\r\n                            <!-- Spacing -->\r\n                            <tr>\r\n                                <td align="center" st-content="preheader" style="font-family: Helvetica, arial, sans-serif; font-size: 10px;color: #999999" valign="middle">\r\n                                    If you don\'t want to receive updates. please\r\n                                    <a class="hlite" href="#" style="text-decoration: none; color: #0db9ea">\r\n                                        unsubscribe\r\n                                    </a>\r\n                                </td>\r\n                            </tr>\r\n                            <!-- Spacing -->\r\n                            <tr>\r\n                                <td height="5" width="100%">\r\n                                </td>\r\n                            </tr>\r\n                            <!-- Spacing -->\r\n                        </tbody>\r\n                    </table>\r\n                </td>\r\n            </tr>\r\n        </tbody>\r\n    </table>\r\n    <!-- End of preheader -->\r\n</div>', 'no@noemail.com', 'Test', 2, '2016-07-19 06:24:08', '2016-07-19 06:30:21'),
(3, 'exam-result', 'exam-result', 'content', 'Exam Result', '<div class="block">\r\n   <!-- Full + text -->\r\n   <table width="100%" bgcolor="#f6f4f5" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="fullimage">\r\n      <tbody>\r\n         <tr>\r\n            <td>\r\n               <table bgcolor="#ffffff" width="580" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth" modulebg="edit">\r\n                  <tbody>\r\n                     <tr>\r\n                        <td width="100%" height="20"></td>\r\n                     </tr>\r\n                     <tr>\r\n                        <td>\r\n                           <table width="540" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidthinner">\r\n                              <tbody>\r\n                                 <!-- title -->\r\n                                 <tr>\r\n                                    <td style="font-family: Helvetica, arial, sans-serif; font-size: 18px; color: #333333; text-align:left;line-height: 20px;" st-title="rightimage-title"> LOREM IPSUM </td>\r\n                                 </tr>\r\n                                 <!-- end of title -->\r\n                                 <!-- Spacing -->\r\n                                 <tr>\r\n                                    <td width="100%" height="10"></td>\r\n                                 </tr>\r\n                                 <!-- Spacing -->\r\n                                 <!-- content -->\r\n                                 <tr>\r\n                                    <td style="font-family: Helvetica, arial, sans-serif; font-size: 13px; color: #666666; text-align:left;line-height: 24px;" st-content="rightimage-paragraph"> {{ $content }} </td>\r\n                                 </tr>\r\n                                 <!-- end of content -->\r\n                                 <!-- Spacing -->\r\n                                 <tr>\r\n                                    <td width="100%" height="10"></td>\r\n                                 </tr>\r\n                                 \r\n                                 <!-- Spacing -->\r\n                                 <tr>\r\n                                    <td width="100%" height="10"></td>\r\n                                 </tr>\r\n                                 <!-- button -->\r\n                                 <tr>\r\n                                    <td>\r\n                                       <table height="30" align="left" valign="middle" border="0" cellpadding="0" cellspacing="0" class="tablet-button" st-button="edit">\r\n                                          <tbody>\r\n                                             <tr>\r\n                                                <td width="auto" align="center" valign="middle" height="30" style=" background-color:#0db9ea; border-top-left-radius:4px; border-bottom-left-radius:4px;border-top-right-radius:4px; border-bottom-right-radius:4px; background-clip: padding-box;font-size:13px; font-family:Helvetica, arial, sans-serif; text-align:center;  color:#ffffff; font-weight: 300; padding-left:18px; padding-right:18px;"> <span style="color: #ffffff; font-weight: 300;">\r\n                                                   <a style="color: #ffffff; text-align:center;text-decoration: none;" href="#">Read More</a>\r\n                                                   </span> \r\n                                                </td>\r\n                                             </tr>\r\n                                          </tbody>\r\n                                       </table>\r\n                                    </td>\r\n                                 </tr>\r\n                                 <!-- /button -->\r\n                                 <!-- Spacing -->\r\n                                 <tr>\r\n                                    <td width="100%" height="20"></td>\r\n                                 </tr>\r\n                                 <!-- Spacing -->\r\n                              </tbody>\r\n                           </table>\r\n                        </td>\r\n                     </tr>\r\n                  </tbody>\r\n               </table>\r\n            </td>\r\n         </tr>\r\n      </tbody>\r\n   </table>\r\n</div>', 'admin@gmail.com', 'Test', 2, '2016-07-19 06:37:51', '2016-07-19 06:37:51'),
(4, 'registration', 'registration', '', 'Welcome', '<!-- Full + text -->\r\n<table border="0" cellpadding="0" cellspacing="0" style="width:100%">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<table align="center" border="0" cellpadding="0" cellspacing="0" style="width:580px">\r\n				<tbody>\r\n					<tr>\r\n						<td>&nbsp;</td>\r\n					</tr>\r\n					<tr>\r\n						<td>\r\n						<table align="center" border="0" cellpadding="0" cellspacing="0" style="width:540px">\r\n							<tbody><!-- title -->\r\n								<tr>\r\n									<td style="text-align:left">&nbsp;</td>\r\n								</tr>\r\n								<!-- end of title --><!-- Spacing -->\r\n								<tr>\r\n									<td>&nbsp;</td>\r\n								</tr>\r\n								<!-- Spacing --><!-- content -->\r\n								<tr>\r\n									<td style="text-align:left">\r\n									<p>Dear {{ $username }},<br />\r\n									You have successfully registered with Academia. Enjoy the facilities provided by our system.</p>\r\n\r\n									<p>Please contact admin for further details.</p>\r\n									</td>\r\n								</tr>\r\n								<!-- end of content --><!-- Spacing -->\r\n								<tr>\r\n									<td>&nbsp;</td>\r\n								</tr>\r\n								<!-- Spacing -->\r\n								<tr>\r\n									<td>&nbsp;</td>\r\n								</tr>\r\n								<!-- button -->\r\n								<tr>\r\n									<td>\r\n									<table align="left" border="0" cellpadding="0" cellspacing="0" style="height:30px">\r\n										<tbody>\r\n											<tr>\r\n												<td style="background-color:#0db9ea; text-align:justify"><a href="#">Read More</a></td>\r\n											</tr>\r\n										</tbody>\r\n									</table>\r\n									</td>\r\n								</tr>\r\n								<!-- /button --><!-- Spacing -->\r\n								<tr>\r\n									<td>&nbsp;</td>\r\n								</tr>\r\n								<!-- Spacing -->\r\n							</tbody>\r\n						</table>\r\n						</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n', 'admin@academia.com', 'Academia Admin', 1, '2016-07-29 03:48:18', '2016-10-19 20:10:05'),
(5, 'subscription', 'subscription', '', 'Subscription Successfull', '<div class="block"><!-- Full + text -->\r\n<table border="0" cellpadding="0" cellspacing="0" id="backgroundTable" style="width:100%">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<table align="center" border="0" cellpadding="0" cellspacing="0" class="devicewidth" style="width:580px">\r\n				<tbody>\r\n					<tr>\r\n						<td>&nbsp;</td>\r\n					</tr>\r\n					<tr>\r\n						<td>\r\n						<table align="center" border="0" cellpadding="0" cellspacing="0" class="devicewidthinner" style="width:540px">\r\n							<tbody><!-- title -->\r\n								<tr>\r\n									<td style="text-align:left">&nbsp;</td>\r\n								</tr>\r\n								<!-- end of title --><!-- Spacing -->\r\n								<tr>\r\n									<td>&nbsp;</td>\r\n								</tr>\r\n								<!-- Spacing --><!-- content -->\r\n								<tr>\r\n									<td style="text-align:left">Dear {{ $username }},<br />\r\n									You have successfully subscribed to {{ ucfirst($plan)}} plan with transaction {{$id}}. Enjoy the facilities provided by our system.</td>\r\n								</tr>\r\n								<!-- end of content --><!-- Spacing -->\r\n								<tr>\r\n									<td>&nbsp;</td>\r\n								</tr>\r\n								<!-- Spacing -->\r\n								<tr>\r\n									<td>&nbsp;</td>\r\n								</tr>\r\n								<!-- button -->\r\n								<tr>\r\n									<td>\r\n									<table align="left" border="0" cellpadding="0" cellspacing="0" class="tablet-button" style="height:30px">\r\n										<tbody>\r\n											<tr>\r\n												<td style="background-color:#0db9ea; text-align:center"><span style="color:#ffffff"><a href="#" style="color: #ffffff; text-align:center;text-decoration: none;">Read More</a> </span></td>\r\n											</tr>\r\n										</tbody>\r\n									</table>\r\n									</td>\r\n								</tr>\r\n								<!-- /button --><!-- Spacing -->\r\n								<tr>\r\n									<td>&nbsp;</td>\r\n								</tr>\r\n								<!-- Spacing -->\r\n							</tbody>\r\n						</table>\r\n						</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n</div>\r\n', 'admin@academia.com', 'Jack', 1, '2016-08-03 01:00:58', '2016-09-03 01:59:12'),
(6, 'offline_subscription_failed', 'offline-subscription-failed', '', 'Offline Subscription Failed', '<div class="block"><!-- Full + text -->\r\n<table border="0" cellpadding="0" cellspacing="0" id="backgroundTable" style="width:100%">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<table align="center" border="0" cellpadding="0" cellspacing="0" class="devicewidth" style="width:580px">\r\n				<tbody>\r\n					<tr>\r\n						<td>&nbsp;</td>\r\n					</tr>\r\n					<tr>\r\n						<td>\r\n						<table align="center" border="0" cellpadding="0" cellspacing="0" class="devicewidthinner" style="width:540px">\r\n							<tbody><!-- title -->\r\n								<tr>\r\n									<td style="text-align:left">&nbsp;</td>\r\n								</tr>\r\n								<!-- end of title --><!-- Spacing -->\r\n								<tr>\r\n									<td>&nbsp;</td>\r\n								</tr>\r\n								<!-- Spacing --><!-- content -->\r\n								<tr>\r\n									<td style="text-align:left">\r\n									<p>Dear {{ $username }},<br />\r\n									Your attempt for offline subscription to {{ ucfirst($plan)}} plan is failed.</p>\r\n\r\n									<p>Please find the admin comment</p>\r\n\r\n									<p><u><strong>Admin Comment:</strong></u></p>\r\n\r\n									<p>&nbsp;{{$admin_comment}}.</p>\r\n\r\n									<p>Please contact admin for further details.</p>\r\n									</td>\r\n								</tr>\r\n								<!-- end of content --><!-- Spacing -->\r\n								<tr>\r\n									<td>&nbsp;</td>\r\n								</tr>\r\n								<!-- Spacing -->\r\n								<tr>\r\n									<td>&nbsp;</td>\r\n								</tr>\r\n								<!-- button -->\r\n								<tr>\r\n									<td>\r\n									<table align="left" border="0" cellpadding="0" cellspacing="0" class="tablet-button" style="height:30px">\r\n										<tbody>\r\n											<tr>\r\n												<td style="background-color:#0db9ea; text-align:center"><span style="color:#ffffff"><a href="#" style="color: #ffffff; text-align:center;text-decoration: none;">Read More</a> </span></td>\r\n											</tr>\r\n										</tbody>\r\n									</table>\r\n									</td>\r\n								</tr>\r\n								<!-- /button --><!-- Spacing -->\r\n								<tr>\r\n									<td>&nbsp;</td>\r\n								</tr>\r\n								<!-- Spacing -->\r\n							</tbody>\r\n						</table>\r\n						</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n</div>\r\n', 'admin@academia.com', 'Admin', 1, '2016-10-15 10:31:47', '2016-10-18 14:36:14'),
(7, 'offline_subscription_success', 'offline-subscription-success', '', 'Offline Subscription Success', '<div class="block"><!-- Full + text -->\r\n<table border="0" cellpadding="0" cellspacing="0" id="backgroundTable" style="width:100%">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<table align="center" border="0" cellpadding="0" cellspacing="0" class="devicewidth" style="width:580px">\r\n				<tbody>\r\n					<tr>\r\n						<td>&nbsp;</td>\r\n					</tr>\r\n					<tr>\r\n						<td>\r\n						<table align="center" border="0" cellpadding="0" cellspacing="0" class="devicewidthinner" style="width:540px">\r\n							<tbody><!-- title -->\r\n								<tr>\r\n									<td style="text-align:left">&nbsp;</td>\r\n								</tr>\r\n								<!-- end of title --><!-- Spacing -->\r\n								<tr>\r\n									<td>&nbsp;</td>\r\n								</tr>\r\n								<!-- Spacing --><!-- content -->\r\n								<tr>\r\n									<td style="text-align:left">\r\n									<p>Dear {{ $username }},<br />\r\n									Your attempt for offline subscription to {{ ucfirst($plan)}} plan is success. &nbsp;</p>\r\n\r\n									<p><u><strong>Admin Comment</strong></u></p>\r\n\r\n									<p>&nbsp;{{$admin_comment}}.</p>\r\n\r\n									<p>Please contact admin for further details.</p>\r\n									</td>\r\n								</tr>\r\n								<!-- end of content --><!-- Spacing -->\r\n								<tr>\r\n									<td>&nbsp;</td>\r\n								</tr>\r\n								<!-- Spacing -->\r\n								<tr>\r\n									<td>&nbsp;</td>\r\n								</tr>\r\n								<!-- button -->\r\n								<tr>\r\n									<td>\r\n									<table align="left" border="0" cellpadding="0" cellspacing="0" class="tablet-button" style="height:30px">\r\n										<tbody>\r\n											<tr>\r\n												<td style="background-color: rgb(13, 185, 234); text-align: justify;"><span style="color:#ffffff"><a href="#" style="color: #ffffff; text-align:center;text-decoration: none;">Read More</a> </span></td>\r\n											</tr>\r\n										</tbody>\r\n									</table>\r\n									</td>\r\n								</tr>\r\n								<!-- /button --><!-- Spacing -->\r\n								<tr>\r\n									<td>&nbsp;</td>\r\n								</tr>\r\n								<!-- Spacing -->\r\n							</tbody>\r\n						</table>\r\n						</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n</div>\r\n', 'admin@academia.com', 'Admin', 1, '2016-10-15 10:35:32', '2016-10-18 14:27:15'),
(8, 'subscription_success', 'subscription-success', '', 'Your Subscription was Success', '<!-- Full + text -->\r\n<table border="0" cellpadding="0" cellspacing="0" style="width:100%">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<table align="center" border="0" cellpadding="0" cellspacing="0" style="width:580px">\r\n				<tbody>\r\n					<tr>\r\n						<td>&nbsp;</td>\r\n					</tr>\r\n					<tr>\r\n						<td>\r\n						<table align="center" border="0" cellpadding="0" cellspacing="0" style="width:540px">\r\n							<tbody><!-- title -->\r\n								<tr>\r\n									<td style="text-align:left">&nbsp;</td>\r\n								</tr>\r\n								<!-- end of title --><!-- Spacing -->\r\n								<tr>\r\n									<td>&nbsp;</td>\r\n								</tr>\r\n								<!-- Spacing --><!-- content -->\r\n								<tr>\r\n									<td style="text-align:left">\r\n									<p>Dear {{ $username }},<br />\r\n									Your subscription to {{ ucfirst($plan)}} plan is success. &nbsp;</p>\r\n\r\n									<p>Please contact admin for further details.</p>\r\n									</td>\r\n								</tr>\r\n								<!-- end of content --><!-- Spacing -->\r\n								<tr>\r\n									<td>&nbsp;</td>\r\n								</tr>\r\n								<!-- Spacing -->\r\n								<tr>\r\n									<td>&nbsp;</td>\r\n								</tr>\r\n								<!-- button -->\r\n								<tr>\r\n									<td>\r\n									<table align="left" border="0" cellpadding="0" cellspacing="0" style="height:30px">\r\n										<tbody>\r\n											<tr>\r\n												<td style="background-color:#0db9ea; text-align:justify"><a href="#">Read More</a></td>\r\n											</tr>\r\n										</tbody>\r\n									</table>\r\n									</td>\r\n								</tr>\r\n								<!-- /button --><!-- Spacing -->\r\n								<tr>\r\n									<td>&nbsp;</td>\r\n								</tr>\r\n								<!-- Spacing -->\r\n							</tbody>\r\n						</table>\r\n						</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n', 'admin@academia.com', 'Admin', 1, '2016-10-19 15:31:21', '2016-10-19 15:31:21');

-- --------------------------------------------------------

--
-- Table structure for table `examseries`
--

CREATE TABLE `examseries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `is_paid` tinyint(1) NOT NULL DEFAULT '0',
  `cost` decimal(10,2) NOT NULL,
  `validity` int(11) NOT NULL,
  `total_exams` int(11) NOT NULL,
  `total_questions` int(11) NOT NULL,
  `image` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `short_description` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `record_updated_by` int(11) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `examseries_data`
--

CREATE TABLE `examseries_data` (
  `id` int(10) UNSIGNED NOT NULL,
  `examseries_id` bigint(20) UNSIGNED NOT NULL,
  `quiz_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `examtoppers`
--

CREATE TABLE `examtoppers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `quiz_id` bigint(20) UNSIGNED NOT NULL,
  `percentage` decimal(10,2) NOT NULL,
  `rank` int(11) NOT NULL,
  `quiz_result_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

CREATE TABLE `feedbacks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `read_status` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` int(10) UNSIGNED NOT NULL,
  `percentage_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `grade_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `percentage_from` decimal(10,2) NOT NULL,
  `percentage_to` decimal(10,2) NOT NULL,
  `grade_points` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `percentage_title`, `grade_title`, `percentage_from`, `percentage_to`, `grade_points`, `created_at`, `updated_at`) VALUES
(1, 'Distinction', 'A+', '75.00', '100.00', '10.00', '2016-07-17 18:30:00', '2016-07-17 18:30:00'),
(2, 'First Class', 'A', '60.00', '74.99', '9.00', '2016-07-17 18:30:00', '2016-07-17 18:30:00'),
(3, 'Second Class', 'B', '50.00', '59.99', '7.00', '2016-07-17 18:30:00', '2016-07-17 18:30:00'),
(4, 'Third Class', 'C', '35.00', '49.99', '6.00', '2016-07-17 18:30:00', '2016-07-17 18:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `group` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `instructions`
--

CREATE TABLE `instructions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(10) UNSIGNED NOT NULL,
  `language` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `code` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_rtl` int(11) NOT NULL,
  `is_default` tinyint(2) NOT NULL DEFAULT '0',
  `phrases` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `language`, `slug`, `code`, `is_rtl`, `is_default`, `phrases`, `created_at`, `updated_at`) VALUES
(3, 'Telugu', 'telugu', 'te', 0, 0, '{"success":"\\u0c35\\u0c3f\\u0c1c\\u0c2f\\u0c02","record_updated_successfully":"\\u0c30\\u0c3f\\u0c15\\u0c3e\\u0c30\\u0c4d\\u0c21\\u0c4d \\u0c35\\u0c3f\\u0c1c\\u0c2f\\u0c35\\u0c02\\u0c24\\u0c02\\u0c17\\u0c3e \\u0c28\\u0c35\\u0c40\\u0c15\\u0c30\\u0c3f\\u0c02\\u0c1a\\u0c2c\\u0c21\\u0c3f\\u0c02\\u0c26\\u0c3f","languages":"\\u0c2d\\u0c3e\\u0c37\\u0c32\\u0c41","create":"\\u0c38\\u0c43\\u0c37\\u0c4d\\u0c1f\\u0c3f\\u0c02\\u0c1a\\u0c41","language":"\\u0c2d\\u0c3e\\u0c37\\u0c3e","code":"\\u0c15\\u0c4b\\u0c21\\u0c4d","is_rtl":"RTL \\u0c09\\u0c02\\u0c26\\u0c3f","default_language":"\\u0c21\\u0c3f\\u0c2b\\u0c3e\\u0c32\\u0c4d\\u0c1f\\u0c4d \\u0c2d\\u0c3e\\u0c37\\u0c3e","action":"\\u0c2f\\u0c3e\\u0c15\\u0c4d\\u0c37\\u0c28\\u0c4d","site_title":"\\u0c38\\u0c46\\u0c56\\u0c1f\\u0c4d \\u0c36\\u0c40\\u0c30\\u0c4d\\u0c37\\u0c3f\\u0c15","latest_users":"\\u0c24\\u0c3e\\u0c1c\\u0c3e \\u0c35\\u0c3f\\u0c28\\u0c3f\\u0c2f\\u0c4b\\u0c17\\u0c26\\u0c3e\\u0c30\\u0c41\\u0c32\\u0c41","was_joined_as":"\\u0c17\\u0c3e \\u0c1a\\u0c47\\u0c30\\u0c3e\\u0c30\\u0c41 \\u0c1c\\u0c30\\u0c3f\\u0c17\\u0c3f\\u0c28\\u0c26\\u0c3f","see_more":"\\u0c07\\u0c02\\u0c15\\u0c3e \\u0c1a\\u0c42\\u0c21\\u0c02\\u0c21\\u0c3f","my_profile":"\\u0c28\\u0c3e \\u0c1c\\u0c40\\u0c35\\u0c28 \\u0c35\\u0c3f\\u0c35\\u0c30\\u0c23","change_password":"\\u0c2a\\u0c3e\\u0c38\\u0c4d\\u0c35\\u0c30\\u0c4d\\u0c21\\u0c4d \\u0c2e\\u0c3e\\u0c30\\u0c4d\\u0c1a\\u0c02\\u0c21\\u0c3f","logout":"\\u0c32\\u0c3e\\u0c17\\u0c4c\\u0c1f\\u0c4d","dashboard":"\\u0c21\\u0c3e\\u0c37\\u0c4d\\u0c2c\\u0c4b\\u0c30\\u0c4d\\u0c21\\u0c4d","users":"\\u0c35\\u0c3f\\u0c28\\u0c3f\\u0c2f\\u0c4b\\u0c17\\u0c26\\u0c3e\\u0c30\\u0c41\\u0c32\\u0c41","roles":"\\u0c2a\\u0c3e\\u0c24\\u0c4d\\u0c30\\u0c32\\u0c41","fee_settings":"\\u0c2b\\u0c40\\u0c1c\\u0c41 \\u0c38\\u0c46\\u0c1f\\u0c4d\\u0c1f\\u0c3f\\u0c02\\u0c17\\u0c41\\u0c32\\u0c41","fee_categories":"\\u0c2b\\u0c40\\u0c1c\\u0c41 \\u0c35\\u0c30\\u0c4d\\u0c17\\u0c02","fee_category_allotment":"\\u0c2b\\u0c40\\u0c1c\\u0c41 \\u0c35\\u0c30\\u0c4d\\u0c17\\u0c02 \\u0c05\\u0c32\\u0c3e\\u0c1f\\u0c4d\\u0c2e\\u0c46\\u0c02\\u0c1f\\u0c4d","fee_particulars":"\\u0c2b\\u0c40\\u0c1c\\u0c41 \\u0c35\\u0c3f\\u0c35\\u0c30\\u0c2e\\u0c41\\u0c32","fee_schedules":"\\u0c2b\\u0c40\\u0c1c\\u0c41 \\u0c37\\u0c46\\u0c21\\u0c4d\\u0c2f\\u0c42\\u0c32\\u0c4d\\u0c38\\u0c4d","fines":"\\u0c2b\\u0c46\\u0c56\\u0c28\\u0c4d\\u0c38\\u0c4d","discounts":"\\u0c21\\u0c3f\\u0c38\\u0c4d\\u0c15\\u0c4c\\u0c02\\u0c1f\\u0c4d","master_settings":"\\u0c2e\\u0c3e\\u0c38\\u0c4d\\u0c1f\\u0c30\\u0c4d \\u0c38\\u0c46\\u0c1f\\u0c4d\\u0c1f\\u0c3f\\u0c02\\u0c17\\u0c41\\u0c32\\u0c41","religions_master":"\\u0c2e\\u0c24\\u0c3e\\u0c32\\u0c41 \\u0c2e\\u0c3e\\u0c38\\u0c4d\\u0c1f\\u0c30\\u0c4d","academics_master":"\\u0c35\\u0c3f\\u0c26\\u0c4d\\u0c2f\\u0c3e\\u0c35\\u0c47\\u0c24\\u0c4d\\u0c24\\u0c32\\u0c41 \\u0c2e\\u0c3e\\u0c38\\u0c4d\\u0c1f\\u0c30\\u0c4d","courses_master":"\\u0c15\\u0c4b\\u0c30\\u0c4d\\u0c38\\u0c41\\u0c32\\u0c41 \\u0c2e\\u0c3e\\u0c38\\u0c4d\\u0c1f\\u0c30\\u0c4d","subjects_master":"\\u0c35\\u0c3f\\u0c37\\u0c2f\\u0c2e\\u0c41 \\u0c2e\\u0c3e\\u0c38\\u0c4d\\u0c1f\\u0c30\\u0c4d","subject_topics":"\\u0c35\\u0c3f\\u0c37\\u0c2f\\u0c02 \\u0c1f\\u0c3e\\u0c2a\\u0c3f\\u0c15\\u0c4d\\u0c38\\u0c4d","course_subjects":"\\u0c15\\u0c4b\\u0c30\\u0c4d\\u0c38\\u0c41 \\u0c35\\u0c3f\\u0c37\\u0c2f\\u0c2e\\u0c41","email_templates":"\\u0c07\\u0c2e\\u0c46\\u0c2f\\u0c3f\\u0c32\\u0c4d \\u0c1f\\u0c46\\u0c02\\u0c2a\\u0c4d\\u0c32\\u0c47\\u0c1f\\u0c4d\\u0c32\\u0c28\\u0c41","exams":"\\u0c2a\\u0c30\\u0c40\\u0c15\\u0c4d\\u0c37\\u0c32\\u0c41","categories":"\\u0c35\\u0c30\\u0c4d\\u0c17\\u0c02","question_bank":"\\u0c2a\\u0c4d\\u0c30\\u0c36\\u0c4d\\u0c28 \\u0c2c\\u0c4d\\u0c2f\\u0c3e\\u0c02\\u0c15\\u0c4d","quiz":"\\u0c15\\u0c4d\\u0c35\\u0c3f\\u0c1c\\u0c4d","lms":"LMS","content":"\\u0c15\\u0c02\\u0c1f\\u0c46\\u0c02\\u0c1f\\u0c4d","study_materials":"\\u0c38\\u0c4d\\u0c1f\\u0c21\\u0c40 \\u0c2e\\u0c46\\u0c1f\\u0c40\\u0c30\\u0c3f\\u0c2f\\u0c32\\u0c4d\\u0c38\\u0c4d","library":"\\u0c32\\u0c46\\u0c56\\u0c2c\\u0c4d\\u0c30\\u0c30\\u0c40","asset_types":"\\u0c06\\u0c38\\u0c4d\\u0c24\\u0c3f \\u0c30\\u0c15\\u0c3e\\u0c32\\u0c41","master_data":"\\u0c2e\\u0c41\\u0c16\\u0c4d\\u0c2f \\u0c38\\u0c2e\\u0c3e\\u0c1a\\u0c3e\\u0c30","publishers":"\\u0c2a\\u0c2c\\u0c4d\\u0c32\\u0c3f\\u0c37\\u0c30\\u0c4d\\u0c38\\u0c4d","authors":"\\u0c30\\u0c1a\\u0c2f\\u0c3f\\u0c24\\u0c32\\u0c41","students":"\\u0c38\\u0c4d\\u0c1f\\u0c42\\u0c21\\u0c46\\u0c02\\u0c1f\\u0c4d\\u0c38\\u0c4d","staff":"\\u0c38\\u0c4d\\u0c1f\\u0c3e\\u0c2b\\u0c4d","school_hub":"\\u0c38\\u0c4d\\u0c15\\u0c42\\u0c32\\u0c4d \\u0c39\\u0c2c\\u0c4d","attendance":"\\u0c39\\u0c3e\\u0c1c\\u0c30\\u0c41","edit":"\\u0c2e\\u0c3e\\u0c30\\u0c4d\\u0c1a\\u0c41","delete":"\\u0c24\\u0c4a\\u0c32\\u0c17\\u0c3f\\u0c02\\u0c1a\\u0c41","enable":"\\u0c2a\\u0c4d\\u0c30\\u0c3e\\u0c30\\u0c02\\u0c2d\\u0c3f\\u0c02\\u0c1a\\u0c41","set_default":"\\u0c38\\u0c46\\u0c1f\\u0c4d \\u0c21\\u0c3f\\u0c2b\\u0c3e\\u0c32\\u0c4d\\u0c1f\\u0c4d","disable":"\\u0c21\\u0c3f\\u0c38\\u0c47\\u0c2c\\u0c41\\u0c32\\u0c4d","admin_dashboard":"\\u0c05\\u0c21\\u0c4d\\u0c2e\\u0c3f\\u0c28\\u0c4d \\u0c21\\u0c3e\\u0c37\\u0c4d\\u0c2c\\u0c4b\\u0c30\\u0c4d\\u0c21\\u0c4d","overall_users":"\\u0c2e\\u0c4a\\u0c24\\u0c4d\\u0c24\\u0c02\\u0c2e\\u0c40\\u0c26 \\u0c35\\u0c3f\\u0c28\\u0c3f\\u0c2f\\u0c4b\\u0c17\\u0c26\\u0c3e\\u0c30\\u0c41\\u0c32\\u0c41","user_statistics":"\\u0c35\\u0c3e\\u0c21\\u0c41\\u0c15\\u0c30\\u0c3f \\u0c17\\u0c23\\u0c3e\\u0c02\\u0c15\\u0c3e\\u0c32\\u0c41","user_details":"\\u0c35\\u0c3e\\u0c21\\u0c41\\u0c15\\u0c30\\u0c3f \\u0c35\\u0c3f\\u0c35\\u0c30\\u0c3e\\u0c32\\u0c41","view_all":"\\u0c05\\u0c28\\u0c4d\\u0c28\\u0c40 \\u0c1a\\u0c42\\u0c21\\u0c41","quiz_categories":"\\u0c15\\u0c4d\\u0c35\\u0c3f\\u0c1c\\u0c4d \\u0c35\\u0c30\\u0c4d\\u0c17\\u0c02","quizzes":"\\u0c15\\u0c4d\\u0c35\\u0c3f\\u0c1c\\u0c46\\u0c38\\u0c4d","subjects":"\\u0c35\\u0c3f\\u0c37\\u0c2f\\u0c2e\\u0c41","topics":"\\u0c35\\u0c3f\\u0c37\\u0c2f\\u0c3e\\u0c32\\u0c41","questions":"\\u0c2a\\u0c4d\\u0c30\\u0c36\\u0c4d\\u0c28\\u0c32\\u0c41","title":"\\u0c36\\u0c40\\u0c30\\u0c4d\\u0c37\\u0c3f\\u0c15","dueration":"Dueration","category":"\\u0c35\\u0c30\\u0c4d\\u0c17\\u0c02","is_paid":"\\u0c1a\\u0c46\\u0c32\\u0c4d\\u0c32\\u0c3f\\u0c38\\u0c4d\\u0c24\\u0c41\\u0c28\\u0c4d\\u0c28\\u0c2a\\u0c4d\\u0c2a\\u0c1f\\u0c3f\\u0c15\\u0c40","total_marks":"\\u0c2e\\u0c4a\\u0c24\\u0c4d\\u0c24\\u0c02 \\u0c2e\\u0c3e\\u0c30\\u0c4d\\u0c15\\u0c41\\u0c32\\u0c41","update_questions":"\\u0c28\\u0c35\\u0c40\\u0c15\\u0c30\\u0c23 \\u0c2a\\u0c4d\\u0c30\\u0c36\\u0c4d\\u0c28","free":"\\u0c09\\u0c1a\\u0c3f\\u0c24","paid":"\\u0c1a\\u0c46\\u0c32\\u0c4d\\u0c32\\u0c3f\\u0c02\\u0c2a\\u0c41","create_quiz":"\\u0c15\\u0c4d\\u0c35\\u0c3f\\u0c1c\\u0c4d \\u0c38\\u0c43\\u0c37\\u0c4d\\u0c1f\\u0c3f\\u0c02\\u0c1a\\u0c41","list":"\\u0c1c\\u0c3e\\u0c2c\\u0c3f\\u0c24\\u0c3e","quiz_title":"\\u0c15\\u0c4d\\u0c35\\u0c3f\\u0c1c\\u0c4d \\u0c36\\u0c40\\u0c30\\u0c4d\\u0c37\\u0c3f\\u0c15","enter_value_in_minutes":"\\u0c35\\u0c3f\\u0c32\\u0c41\\u0c35 \\u0c2e\\u0c3f\\u0c28\\u0c3f\\u0c1f\\u0c4d\\u0c38\\u0c4d \\u0c32\\u0c4b \\u0c0e\\u0c02\\u0c1f\\u0c30\\u0c4d","it will be updated by adding the questions":"\\u0c07\\u0c26\\u0c3f \\u0c2a\\u0c4d\\u0c30\\u0c36\\u0c4d\\u0c28\\u0c32\\u0c41 \\u0c1c\\u0c4b\\u0c21\\u0c3f\\u0c02\\u0c1a\\u0c21\\u0c02 \\u0c26\\u0c4d\\u0c35\\u0c3e\\u0c30\\u0c3e \\u0c05\\u0c2a\\u0c4d\\u0c21\\u0c47\\u0c1f\\u0c4d \\u0c05\\u0c35\\u0c41\\u0c24\\u0c41\\u0c02\\u0c26\\u0c3f","pass_percentage":"\\u0c09\\u0c24\\u0c4d\\u0c24\\u0c40\\u0c30\\u0c4d\\u0c23\\u0c24 \\u0c36\\u0c3e\\u0c24\\u0c02","no":"\\u0c24\\u0c4b\\u0c2c\\u0c41\\u0c1f\\u0c4d\\u0c1f\\u0c41\\u0c35\\u0c41\\u0c32","yes":"\\u0c05\\u0c35\\u0c41\\u0c28\\u0c41","description":"\\u0c35\\u0c3f\\u0c35\\u0c30\\u0c23","add_language":"\\u0c2d\\u0c3e\\u0c37\\u0c3e \\u0c1c\\u0c4b\\u0c21\\u0c3f\\u0c02\\u0c1a\\u0c02\\u0c21\\u0c3f","language_title":"\\u0c2d\\u0c3e\\u0c37\\u0c3e \\u0c36\\u0c40\\u0c30\\u0c4d\\u0c37\\u0c3f\\u0c15","language_code":"\\u0c2d\\u0c3e\\u0c37 \\u0c15\\u0c4b\\u0c21\\u0c4d","supported_language_codes":"\\u0c2e\\u0c26\\u0c4d\\u0c26\\u0c24\\u0c41 \\u0c2d\\u0c3e\\u0c37 \\u0c15\\u0c4b\\u0c21\\u0c4d\\u0c32\\u0c41","home":"\\u0c39\\u0c4b\\u0c2e\\u0c4d","faqs":"FAQS","about_us":"\\u0c2e\\u0c3e \\u0c17\\u0c41\\u0c30\\u0c3f\\u0c02\\u0c1a\\u0c3f","contact_us":"\\u0c2e\\u0c2e\\u0c4d\\u0c2e\\u0c32\\u0c4d\\u0c28\\u0c3f \\u0c38\\u0c02\\u0c2a\\u0c4d\\u0c30\\u0c26\\u0c3f\\u0c02\\u0c1a\\u0c02\\u0c21\\u0c3f","email":"\\u0c07\\u0c2e\\u0c46\\u0c2f\\u0c3f\\u0c32\\u0c4d","password":"\\u0c2a\\u0c3e\\u0c38\\u0c4d\\u0c35\\u0c30\\u0c4d\\u0c21\\u0c4d","login":"\\u0c32\\u0c3e\\u0c17\\u0c3f\\u0c28\\u0c4d","forgot_password":"\\u0c2a\\u0c3e\\u0c38\\u0c4d\\u0c35\\u0c30\\u0c4d\\u0c21\\u0c4d \\u0c2e\\u0c30\\u0c3f\\u0c1a\\u0c3f\\u0c2a\\u0c4b\\u0c2f\\u0c3e\\u0c30\\u0c3e","register":"\\u0c28\\u0c2e\\u0c4b\\u0c26\\u0c41","logged_out_successfully":"\\u0c35\\u0c3f\\u0c1c\\u0c2f\\u0c35\\u0c02\\u0c24\\u0c02\\u0c17\\u0c3e \\u0c32\\u0c3e\\u0c17\\u0c4d \\u0c05\\u0c35\\u0c41\\u0c1f\\u0c4d","edit_subject":"\\u0c35\\u0c3f\\u0c37\\u0c2f\\u0c3e\\u0c28\\u0c4d\\u0c28\\u0c3f \\u0c2e\\u0c3e\\u0c30\\u0c4d\\u0c1a\\u0c41","update":"\\u0c28\\u0c35\\u0c40\\u0c15\\u0c30\\u0c23","subject_title":"\\u0c35\\u0c3f\\u0c37\\u0c2f\\u0c02 \\u0c36\\u0c40\\u0c30\\u0c4d\\u0c37\\u0c3f\\u0c15","subject_code":"\\u0c35\\u0c3f\\u0c37\\u0c2f\\u0c02 \\u0c15\\u0c4b\\u0c21\\u0c4d","is_lab":"\\u0c32\\u0c4d\\u0c2f\\u0c3e\\u0c2c\\u0c4d","is_elective":"\\u0c28\\u0c3f\\u0c2f\\u0c4b\\u0c1c\\u0c3f\\u0c24 \\u0c09\\u0c02\\u0c26\\u0c3f","maximum_marks":"\\u0c17\\u0c30\\u0c3f\\u0c37\\u0c4d\\u0c20 \\u0c2e\\u0c3e\\u0c30\\u0c4d\\u0c15\\u0c4d\\u0c38\\u0c4d","pass_marks":"\\u0c2a\\u0c3e\\u0c38\\u0c4d \\u0c2e\\u0c3e\\u0c30\\u0c4d\\u0c15\\u0c4d\\u0c38\\u0c4d","subjects_list":"\\u0c35\\u0c3f\\u0c37\\u0c2f\\u0c2e\\u0c41 \\u0c1c\\u0c3e\\u0c2c\\u0c3f\\u0c24\\u0c3e","sno":"sno","subject":"\\u0c35\\u0c3f\\u0c37\\u0c2f\\u0c02","max_marks":"\\u0c2e\\u0c3e\\u0c15\\u0c4d\\u0c38\\u0c4d \\u0c2e\\u0c3e\\u0c30\\u0c4d\\u0c15\\u0c4d\\u0c38\\u0c4d","parent":"\\u0c2e\\u0c3e\\u0c24\\u0c43","add_user":"\\u0c35\\u0c3e\\u0c21\\u0c41\\u0c15\\u0c30\\u0c3f \\u0c1c\\u0c4b\\u0c21\\u0c3f\\u0c02\\u0c1a\\u0c02\\u0c21\\u0c3f","name":"\\u0c2a\\u0c47\\u0c30\\u0c41","image":"\\u0c1a\\u0c3f\\u0c24\\u0c4d\\u0c30\\u0c02","role":"\\u0c2a\\u0c3e\\u0c24\\u0c4d\\u0c30","view_profile":"\\u0c2a\\u0c4d\\u0c30\\u0c4a\\u0c2b\\u0c46\\u0c56\\u0c32\\u0c4d \\u0c1a\\u0c42\\u0c21\\u0c41","update_details":"\\u0c28\\u0c35\\u0c40\\u0c15\\u0c30\\u0c23 \\u0c35\\u0c3f\\u0c35\\u0c30\\u0c3e\\u0c32\\u0c41","add_users":"\\u0c35\\u0c3f\\u0c28\\u0c3f\\u0c2f\\u0c4b\\u0c17\\u0c26\\u0c3e\\u0c30\\u0c41\\u0c32\\u0c28\\u0c41 \\u0c1c\\u0c4b\\u0c21\\u0c3f\\u0c02\\u0c1a\\u0c02\\u0c21\\u0c3f","select_role":"\\u0c2a\\u0c3e\\u0c24\\u0c4d\\u0c30 \\u0c0e\\u0c02\\u0c1a\\u0c41\\u0c15\\u0c4b\\u0c02\\u0c21\\u0c3f","user_roles":"\\u0c35\\u0c3e\\u0c21\\u0c41\\u0c15\\u0c30\\u0c3f \\u0c2a\\u0c3e\\u0c24\\u0c4d\\u0c30\\u0c32\\u0c41","permissions":"\\u0c05\\u0c28\\u0c41\\u0c2e\\u0c24\\u0c41\\u0c32\\u0c41","add_role":"\\u0c2a\\u0c3e\\u0c24\\u0c4d\\u0c30 \\u0c1c\\u0c4b\\u0c21\\u0c3f\\u0c02\\u0c1a\\u0c41","role_name":"\\u0c2a\\u0c3e\\u0c24\\u0c4d\\u0c30 \\u0c2a\\u0c47\\u0c30\\u0c41","display_name":"\\u0c2a\\u0c4d\\u0c30\\u0c26\\u0c30\\u0c4d\\u0c36\\u0c3f\\u0c24 \\u0c28\\u0c3e\\u0c2e\\u0c02","list_roles":"\\u0c1c\\u0c3e\\u0c2c\\u0c3f\\u0c24\\u0c3e \\u0c2d\\u0c3e\\u0c26\\u0c4d\\u0c2f\\u0c24\\u0c32\\u0c41","submit":"\\u0c38\\u0c2e\\u0c30\\u0c4d\\u0c2a\\u0c3f\\u0c02\\u0c1a\\u0c02\\u0c21\\u0c3f","religions":"\\u0c2e\\u0c24\\u0c3e\\u0c32\\u0c41","pass_marks_cannot_be_greater_than_maximum_marks":"\\u0c2a\\u0c3e\\u0c38\\u0c4d \\u0c2e\\u0c3e\\u0c30\\u0c4d\\u0c15\\u0c4d\\u0c38\\u0c4d \\u0c17\\u0c30\\u0c3f\\u0c37\\u0c4d\\u0c20 \\u0c2e\\u0c3e\\u0c30\\u0c4d\\u0c15\\u0c4d\\u0c38\\u0c4d \\u0c15\\u0c02\\u0c1f\\u0c47 \\u0c0e\\u0c15\\u0c4d\\u0c15\\u0c41\\u0c35 \\u0c09\\u0c02\\u0c21\\u0c15\\u0c42\\u0c21\\u0c26\\u0c41","please_enter_valid_maximum_marks":"\\u0c26\\u0c2f\\u0c1a\\u0c47\\u0c38\\u0c3f \\u0c1a\\u0c46\\u0c32\\u0c4d\\u0c32\\u0c41\\u0c2c\\u0c3e\\u0c1f\\u0c41 \\u0c05\\u0c2f\\u0c4d\\u0c2f\\u0c47 \\u0c17\\u0c30\\u0c3f\\u0c37\\u0c4d\\u0c20 \\u0c2e\\u0c3e\\u0c30\\u0c4d\\u0c15\\u0c4d\\u0c38\\u0c4d \\u0c0e\\u0c02\\u0c1f\\u0c30\\u0c4d","please_enter_valid_pass_marks":"\\u0c1a\\u0c46\\u0c32\\u0c4d\\u0c32\\u0c41\\u0c2c\\u0c3e\\u0c1f\\u0c41 \\u0c05\\u0c2f\\u0c4d\\u0c2f\\u0c47 \\u0c2a\\u0c3e\\u0c38\\u0c4d \\u0c2e\\u0c3e\\u0c30\\u0c4d\\u0c15\\u0c4d\\u0c38\\u0c4d \\u0c0e\\u0c02\\u0c1f\\u0c30\\u0c4d \\u0c1a\\u0c47\\u0c2f\\u0c02\\u0c21\\u0c3f","deleted":"Deleted","sorry":"Sorry","cannot_delete_this_record_as":"Cannot Delete This Record As","this_field_id_required":"\\u0c08 \\u0c2b\\u0c40\\u0c32\\u0c4d\\u0c21\\u0c4d id \\u0c05\\u0c35\\u0c38\\u0c30\\u0c02","the_text_is_too_short":"\\u0c1f\\u0c46\\u0c15\\u0c4d\\u0c38\\u0c4d\\u0c1f\\u0c4d \\u0c1a\\u0c3e\\u0c32\\u0c3e \\u0c1a\\u0c3f\\u0c28\\u0c4d\\u0c28\\u0c26\\u0c3f","the_text_is_too_long":"\\u0c35\\u0c1a\\u0c28\\u0c02 \\u0c1a\\u0c3e\\u0c32\\u0c3e \\u0c2a\\u0c4a\\u0c21\\u0c35\\u0c41\\u0c17\\u0c3e \\u0c09\\u0c02\\u0c26\\u0c3f","this_field_is_required":"\\u0c08 \\u0c16\\u0c3e\\u0c33\\u0c40\\u0c28\\u0c3f \\u0c24\\u0c2a\\u0c4d\\u0c2a\\u0c28\\u0c3f\\u0c38\\u0c30\\u0c3f\\u0c17\\u0c3e \\u0c2a\\u0c42\\u0c30\\u0c3f\\u0c02\\u0c1a\\u0c35\\u0c32\\u0c46\\u0c28\\u0c41","please_enter_valid_email":"\\u0c1a\\u0c46\\u0c32\\u0c4d\\u0c32\\u0c41\\u0c2c\\u0c3e\\u0c1f\\u0c41 \\u0c05\\u0c2f\\u0c4d\\u0c2f\\u0c47 \\u0c07\\u0c2e\\u0c46\\u0c2f\\u0c3f\\u0c32\\u0c4d \\u0c0e\\u0c02\\u0c1f\\u0c30\\u0c4d \\u0c1a\\u0c47\\u0c2f\\u0c02\\u0c21\\u0c3f","settings":"\\u0c38\\u0c46\\u0c1f\\u0c4d\\u0c1f\\u0c3f\\u0c02\\u0c17\\u0c41\\u0c32\\u0c41","record_deleted_successfully":"\\u0c30\\u0c3f\\u0c15\\u0c3e\\u0c30\\u0c4d\\u0c21\\u0c4d \\u0c24\\u0c4a\\u0c32\\u0c17\\u0c3f\\u0c02\\u0c1a\\u0c3f\\u0c28 \\u0c35\\u0c3f\\u0c1c\\u0c2f\\u0c35\\u0c02\\u0c24\\u0c02\\u0c17\\u0c3e","record_added_successfully":"\\u0c30\\u0c3f\\u0c15\\u0c3e\\u0c30\\u0c4d\\u0c21\\u0c4d \\u0c1a\\u0c47\\u0c30\\u0c4d\\u0c1a\\u0c2c\\u0c21\\u0c3f\\u0c02\\u0c26\\u0c3f \\u0c35\\u0c3f\\u0c1c\\u0c2f\\u0c35\\u0c02\\u0c24\\u0c02\\u0c17\\u0c3e","exam_series":"\\u0c2a\\u0c30\\u0c40\\u0c15\\u0c4d\\u0c37\\u0c3e \\u0c38\\u0c3f\\u0c30\\u0c40\\u0c38\\u0c4d","instructions":"\\u0c38\\u0c42\\u0c1a\\u0c28\\u0c32\\u0c28\\u0c41","coupons":"\\u0c15\\u0c42\\u0c2a\\u0c28\\u0c4d\\u0c32\\u0c41","add":"\\u0c1a\\u0c47\\u0c30\\u0c4d\\u0c1a\\u0c41","contents":"\\u0c35\\u0c3f\\u0c37\\u0c2f \\u0c38\\u0c42\\u0c1a\\u0c3f\\u0c15","series":"\\u0c38\\u0c3f\\u0c30\\u0c40\\u0c38\\u0c4d","notifications":"\\u0c2a\\u0c4d\\u0c30\\u0c15\\u0c1f\\u0c28\\u0c32\\u0c41","messages":"\\u0c38\\u0c02\\u0c26\\u0c47\\u0c36\\u0c3e\\u0c32\\u0c41","feedback":"\\u0c05\\u0c2d\\u0c3f\\u0c2a\\u0c4d\\u0c30\\u0c3e\\u0c2f\\u0c02","couponcodes":"Couponcodes","type":"\\u0c30\\u0c15\\u0c02","discount":"\\u0c21\\u0c3f\\u0c38\\u0c4d\\u0c15\\u0c4c\\u0c02\\u0c1f\\u0c4d","minimum_bill":"\\u0c15\\u0c28\\u0c40\\u0c38 \\u0c2c\\u0c3f\\u0c32\\u0c4d","maximum_discount":"\\u0c17\\u0c30\\u0c3f\\u0c37\\u0c4d\\u0c1f \\u0c24\\u0c17\\u0c4d\\u0c17\\u0c3f\\u0c02\\u0c2a\\u0c41","limit":"\\u0c2a\\u0c30\\u0c3f\\u0c2e\\u0c3f\\u0c24\\u0c3f","status":"\\u0c38\\u0c4d\\u0c25\\u0c3f\\u0c24\\u0c3f","lms_categories":"LMS \\u0c35\\u0c30\\u0c4d\\u0c17\\u0c02","create_coupon":"\\u0c15\\u0c42\\u0c2a\\u0c28\\u0c4d \\u0c38\\u0c43\\u0c37\\u0c4d\\u0c1f\\u0c3f\\u0c02\\u0c1a\\u0c41","invalid_input":"\\u0c1a\\u0c46\\u0c32\\u0c4d\\u0c32\\u0c28\\u0c3f \\u0c07\\u0c28\\u0c4d\\u0c2a\\u0c41\\u0c1f\\u0c4d","coupon_code":"\\u0c15\\u0c42\\u0c2a\\u0c28\\u0c4d \\u0c15\\u0c4b\\u0c21\\u0c4d","value":"\\u0c35\\u0c3f\\u0c32\\u0c41\\u0c35","percent":"\\u0c36\\u0c3e\\u0c24\\u0c02","discount_type":"\\u0c21\\u0c3f\\u0c38\\u0c4d\\u0c15\\u0c4c\\u0c02\\u0c1f\\u0c4d \\u0c1f\\u0c46\\u0c56\\u0c2a\\u0c4d","discount_value":"\\u0c21\\u0c3f\\u0c38\\u0c4d\\u0c15\\u0c4c\\u0c02\\u0c1f\\u0c4d \\u0c35\\u0c3f\\u0c32\\u0c41\\u0c35","enter_value":"\\u0c35\\u0c3f\\u0c32\\u0c41\\u0c35 \\u0c0e\\u0c02\\u0c1f\\u0c30\\u0c4d","please_enter_valid_number":"\\u0c26\\u0c2f\\u0c1a\\u0c47\\u0c38\\u0c3f \\u0c1a\\u0c46\\u0c32\\u0c4d\\u0c32\\u0c41\\u0c2c\\u0c3e\\u0c1f\\u0c41 \\u0c05\\u0c2f\\u0c4d\\u0c2f\\u0c47 \\u0c38\\u0c02\\u0c16\\u0c4d\\u0c2f\\u0c28\\u0c41 \\u0c28\\u0c2e\\u0c4b\\u0c26\\u0c41","discount_maximum_amount":"\\u0c21\\u0c3f\\u0c38\\u0c4d\\u0c15\\u0c4c\\u0c02\\u0c1f\\u0c4d \\u0c17\\u0c30\\u0c3f\\u0c37\\u0c4d\\u0c1f \\u0c2e\\u0c4a\\u0c24\\u0c4d\\u0c24\\u0c02","valid_from":"\\u0c28\\u0c41\\u0c02\\u0c21\\u0c3f \\u0c1a\\u0c46\\u0c32\\u0c4d\\u0c32\\u0c41\\u0c2c\\u0c3e\\u0c1f\\u0c41 \\u0c05\\u0c2f\\u0c4d\\u0c2f\\u0c47","valid_to":"\\u0c38\\u0c2e\\u0c4d\\u0c2e\\u0c24\\u0c2e\\u0c46\\u0c56\\u0c28","usage_limit":"\\u0c35\\u0c3e\\u0c21\\u0c41\\u0c15 \\u0c2a\\u0c30\\u0c3f\\u0c2e\\u0c3f\\u0c24\\u0c3f","create_series":"\\u0c38\\u0c3f\\u0c30\\u0c40\\u0c38\\u0c4d\\u0c28\\u0c41 \\u0c38\\u0c43\\u0c37\\u0c4d\\u0c1f\\u0c3f\\u0c02\\u0c1a\\u0c41","cost":"\\u0c16\\u0c30\\u0c40\\u0c26\\u0c41","validity":"\\u0c1a\\u0c46\\u0c32\\u0c4d\\u0c32\\u0c41\\u0c2c\\u0c3e\\u0c1f\\u0c41","total_exams":"\\u0c2e\\u0c4a\\u0c24\\u0c4d\\u0c24\\u0c02 \\u0c2a\\u0c30\\u0c40\\u0c15\\u0c4d\\u0c37\\u0c32\\u0c41","total_questions":"\\u0c2e\\u0c4a\\u0c24\\u0c4d\\u0c24\\u0c02 \\u0c2a\\u0c4d\\u0c30\\u0c36\\u0c4d\\u0c28\\u0c32\\u0c41","update_quizzes":"\\u0c28\\u0c35\\u0c40\\u0c15\\u0c30\\u0c23 \\u0c15\\u0c4d\\u0c35\\u0c3f\\u0c1c\\u0c4d\\u0c32\\u0c41","update_series_for":"\\u0c28\\u0c35\\u0c40\\u0c15\\u0c30\\u0c23 \\u0c38\\u0c3f\\u0c30\\u0c40\\u0c38\\u0c4d","exam_categories":"\\u0c2a\\u0c30\\u0c40\\u0c15\\u0c4d\\u0c37\\u0c3e \\u0c35\\u0c30\\u0c4d\\u0c17\\u0c02","saved_exams":"\\u0c38\\u0c47\\u0c35\\u0c4d \\u0c2a\\u0c30\\u0c40\\u0c15\\u0c4d\\u0c37\\u0c32\\u0c41","no_data_available":"\\u0c21\\u0c47\\u0c1f\\u0c3e \\u0c05\\u0c02\\u0c26\\u0c41\\u0c2c\\u0c3e\\u0c1f\\u0c41\\u0c32\\u0c4b \\u0c32\\u0c47\\u0c35\\u0c41","remove_all":"\\u0c05\\u0c28\\u0c4d\\u0c28\\u0c3f \\u0c24\\u0c40\\u0c38\\u0c3f\\u0c35\\u0c46\\u0c2f\\u0c4d","marks":"\\u0c2e\\u0c3e\\u0c30\\u0c4d\\u0c15\\u0c4d\\u0c38\\u0c4d","import_excel":"\\u0c26\\u0c3f\\u0c17\\u0c41\\u0c2e\\u0c24\\u0c3f Excel","edit_user":"\\u0c35\\u0c3e\\u0c21\\u0c41\\u0c15\\u0c30\\u0c3f \\u0c2e\\u0c3e\\u0c30\\u0c4d\\u0c1a\\u0c41","username":"\\u0c2f\\u0c42\\u0c1c\\u0c30\\u0c4d \\u0c2a\\u0c47\\u0c30\\u0c41","phone":"\\u0c2b\\u0c4b\\u0c28\\u0c4d","please_enter_valid_phone_number":"\\u0c26\\u0c2f\\u0c1a\\u0c47\\u0c38\\u0c3f \\u0c1a\\u0c46\\u0c32\\u0c4d\\u0c32\\u0c41\\u0c2c\\u0c3e\\u0c1f\\u0c41 \\u0c05\\u0c2f\\u0c4d\\u0c2f\\u0c47 \\u0c2b\\u0c4b\\u0c28\\u0c4d \\u0c28\\u0c02\\u0c2c\\u0c30\\u0c4d \\u0c0e\\u0c02\\u0c1f\\u0c30\\u0c4d","address":"\\u0c1a\\u0c3f\\u0c30\\u0c41\\u0c28\\u0c3e\\u0c2e\\u0c3e"}', '2016-05-24 23:11:51', '2016-10-19 19:26:39'),
(5, 'Arbic', 'arbic', 'ar', 1, 0, '{"exam_analysis":"\\u062a\\u062d\\u0644\\u064a\\u0644 \\u0627\\u0644\\u0627\\u0645\\u062a\\u062d\\u0627\\u0646","analysis_by_exam":"\\u062a\\u062d\\u0644\\u064a\\u0644 \\u0628\\u0648\\u0627\\u0633\\u0637\\u0629 \\u0627\\u0645\\u062a\\u062d\\u0627\\u0646","of":"of","title":"\\u0639\\u0646\\u0648\\u0627\\u0646","type":"\\u0627\\u0643\\u062a\\u0628","dueration":"Dueration","marks":"\\u0639\\u0644\\u0627\\u0645\\u0627\\u062a","attempts":"\\u0645\\u062d\\u0627\\u0648\\u0644\\u0627\\u062a","action":"\\u0639\\u0645\\u0644","site_title":"\\u0639\\u0646\\u0648\\u0627\\u0646 \\u0627\\u0644\\u0645\\u0648\\u0642\\u0639","my_profile":"\\u0645\\u0644\\u0641\\u064a \\u0627\\u0644\\u0634\\u062e\\u0635\\u064a","change_password":"\\u062a\\u063a\\u064a\\u064a\\u0631 \\u0643\\u0644\\u0645\\u0629 \\u0627\\u0644\\u0633\\u0631","logout":"\\u062e\\u0631\\u0648\\u062c","dashboard":"\\u0644\\u0648\\u062d\\u0629 \\u0627\\u0644\\u0642\\u064a\\u0627\\u062f\\u0629","children":"\\u0627\\u0644\\u0623\\u0637\\u0641\\u0627\\u0644","add":"\\u0625\\u0636\\u0627\\u0641\\u0629","list":"\\u0642\\u0627\\u0626\\u0645\\u0629","exams":"\\u0627\\u0644\\u0627\\u0645\\u062a\\u062d\\u0627\\u0646\\u0627\\u062a","categories":"\\u0627\\u0644\\u0641\\u0626\\u0627\\u062a","recent_activity":"\\u0622\\u062e\\u0631 \\u0646\\u0634\\u0627\\u0637","home":"\\u0627\\u0644\\u0635\\u0641\\u062d\\u0629 \\u0627\\u0644\\u0631\\u0626\\u064a\\u0633\\u064a\\u0629","faqs":"\\u0627\\u0644\\u0623\\u0633\\u0626\\u0644\\u0629 \\u0627\\u0644\\u0623\\u0643\\u062b\\u0631 \\u0634\\u064a\\u0648\\u0639\\u0627","about_us":"\\u0645\\u0639\\u0644\\u0648\\u0645\\u0627\\u062a \\u0639\\u0646\\u0627","contact_us":"\\u0627\\u062a\\u0635\\u0644 \\u0628\\u0646\\u0627","email":"\\u0627\\u0644\\u0628\\u0631\\u064a\\u062f \\u0627\\u0644\\u0625\\u0644\\u0643\\u062a\\u0631\\u0648\\u0646\\u064a","password":"\\u0643\\u0644\\u0645\\u0647 \\u0627\\u0644\\u0633\\u0631","login":"\\u062a\\u0633\\u062c\\u064a\\u0644 \\u0627\\u0644\\u062f\\u062e\\u0648\\u0644","forgot_password":"\\u0647\\u0644 \\u0646\\u0633\\u064a\\u062a \\u0643\\u0644\\u0645\\u0629 \\u0627\\u0644\\u0645\\u0631\\u0648\\u0631","register":"\\u062a\\u0633\\u062c\\u064a\\u0644","quiz_categories":"\\u0645\\u0633\\u0627\\u0628\\u0642\\u0629 \\u0627\\u0644\\u0641\\u0626\\u0627\\u062a","view_all":"\\u0645\\u0634\\u0627\\u0647\\u062f\\u0629 \\u0627\\u0644\\u0643\\u0644","quizzes":"\\u0645\\u0633\\u0627\\u0628\\u0642\\u0627\\u062a","admin_dashboard":"\\u0644\\u0648\\u062d\\u0629 \\u0627\\u0644\\u0645\\u0634\\u0631\\u0641","overall_users":"\\u0627\\u0644\\u0645\\u0633\\u062a\\u062e\\u062f\\u0645\\u0648\\u0646 \\u0627\\u0644\\u0639\\u0627\\u0645","user_statistics":"\\u0627\\u0644\\u0627\\u062d\\u0635\\u0627\\u0626\\u064a\\u0627\\u062a \\u0627\\u0644\\u0645\\u0633\\u062a\\u062e\\u062f\\u0645","user_details":"\\u0628\\u064a\\u0627\\u0646\\u0627\\u062a \\u0627\\u0644\\u0645\\u0633\\u062a\\u062e\\u062f\\u0645","users":"\\u0627\\u0644\\u0645\\u0633\\u062a\\u062e\\u062f\\u0645\\u064a\\u0646","subjects":"\\u0627\\u0644\\u0645\\u0648\\u0627\\u0636\\u064a\\u0639","topics":"\\u0627\\u0644\\u0645\\u0648\\u0627\\u0636\\u064a\\u0639","questions":"\\u0623\\u0633\\u0626\\u0644\\u0629","latest_users":"\\u0623\\u062d\\u062f\\u062b \\u0627\\u0644\\u0645\\u0633\\u062a\\u062e\\u062f\\u0645\\u064a\\u0646","was_joined_as":"\\u0648\\u0642\\u062f \\u0627\\u0646\\u0636\\u0645\\u062a \\u0625\\u0644\\u0649","see_more":"\\u0634\\u0627\\u0647\\u062f \\u0627\\u0644\\u0645\\u0632\\u064a\\u062f","languages":"\\u0627\\u0644\\u0644\\u063a\\u0627\\u062a","roles":"\\u0627\\u0644\\u0623\\u062f\\u0648\\u0627\\u0631","fee_settings":"\\u0625\\u0639\\u062f\\u0627\\u062f\\u0627\\u062a \\u0631\\u0633\\u0648\\u0645","fee_categories":"\\u0631\\u0633\\u0648\\u0645 \\u0627\\u0644\\u0641\\u0626\\u0627\\u062a","fee_category_allotment":"\\u0631\\u0633\\u0648\\u0645 \\u0627\\u0644\\u0641\\u0626\\u0629 \\u0627\\u0644\\u062a\\u062e\\u0635\\u064a\\u0635","fee_particulars":"\\u062a\\u0641\\u0627\\u0635\\u064a\\u0644 \\u0627\\u0644\\u0631\\u0633\\u0648\\u0645","fee_schedules":"\\u062c\\u062f\\u0627\\u0648\\u0644 \\u0631\\u0633\\u0648\\u0645","fines":"\\u0627\\u0644\\u063a\\u0631\\u0627\\u0645\\u0627\\u062a","discounts":"\\u062e\\u0635\\u0648\\u0645\\u0627\\u062a","master_settings":"\\u0625\\u0639\\u062f\\u0627\\u062f\\u0627\\u062a \\u0645\\u0627\\u0633\\u062a\\u0631","religions_master":"\\u0627\\u0644\\u0623\\u062f\\u064a\\u0627\\u0646 \\u0645\\u0627\\u0633\\u062a\\u0631","academics_master":"\\u0623\\u0643\\u0627\\u062f\\u064a\\u0645\\u064a\\u0648\\u0646 \\u0645\\u0627\\u0633\\u062a\\u0631","courses_master":"\\u0645\\u0642\\u0631\\u0631\\u0627\\u062a \\u0627\\u0644\\u0645\\u0627\\u062c\\u0633\\u062a\\u064a\\u0631","subjects_master":"\\u0627\\u0644\\u0645\\u0648\\u0627\\u0636\\u064a\\u0639 \\u0645\\u0627\\u0633\\u062a\\u0631","subject_topics":"\\u062a\\u062e\\u0636\\u0639 \\u0645\\u0648\\u0627\\u0636\\u064a\\u0639","course_subjects":"\\u0627\\u0644\\u0645\\u0648\\u0636\\u0648\\u0639\\u0627\\u062a \\u0628\\u0627\\u0644\\u0637\\u0628\\u0639","email_templates":"\\u0642\\u0648\\u0627\\u0644\\u0628 \\u0627\\u0644\\u0628\\u0631\\u064a\\u062f \\u0627\\u0644\\u0625\\u0644\\u0643\\u062a\\u0631\\u0648\\u0646\\u064a","question_bank":"\\u0627\\u0644\\u0628\\u0646\\u0643 \\u0633\\u0624\\u0627\\u0644","quiz":"\\u0627\\u062e\\u062a\\u0628\\u0627\\u0631 \\u0642\\u0635\\u064a\\u0631","lms":"LMS","content":"\\u0645\\u062d\\u062a\\u0648\\u0649","study_materials":"\\u0645\\u0648\\u0627\\u062f \\u062f\\u0631\\u0627\\u0633\\u064a\\u0629","library":"\\u0645\\u0643\\u062a\\u0628\\u0629","asset_types":"\\u0623\\u0646\\u0648\\u0627\\u0639 \\u0627\\u0644\\u0623\\u0635\\u0648\\u0644","master_data":"\\u0627\\u0644\\u0628\\u064a\\u0627\\u0646\\u0627\\u062a \\u0627\\u0644\\u0631\\u0626\\u064a\\u0633\\u064a\\u0629","publishers":"\\u0646\\u0627\\u0634\\u0631\\u064a","authors":"\\u0627\\u0644\\u0643\\u062a\\u0627\\u0628","students":"\\u0627\\u0644\\u0637\\u0644\\u0627\\u0628","staff":"\\u0627\\u0644\\u0639\\u0627\\u0645\\u0644\\u064a\\u0646","school_hub":"\\u0645\\u062d\\u0648\\u0631 \\u0627\\u0644\\u0645\\u062f\\u0631\\u0633\\u0629","attendance":"\\u0627\\u0644\\u062d\\u0636\\u0648\\u0631","create":"\\u062e\\u0644\\u0642","category":"\\u0641\\u0626\\u0629","is_paid":"\\u0645\\u062f\\u0641\\u0648\\u0639","total_marks":"\\u0645\\u062c\\u0645\\u0648\\u0639 \\u0627\\u0644\\u062f\\u0631\\u062c\\u0627\\u062a","update_questions":"\\u062a\\u062d\\u062f\\u064a\\u062b \\u0627\\u0644\\u0623\\u0633\\u0626\\u0644\\u0629","edit":"\\u062a\\u062d\\u0631\\u064a\\u0631","delete":"\\u062d\\u0630\\u0641","free":"\\u062d\\u0631","paid":"\\u062f\\u0641\\u0639","create_quiz":"\\u0625\\u0646\\u0634\\u0627\\u0621 \\u0645\\u0633\\u0627\\u0628\\u0642\\u0629","quiz_title":"\\u0639\\u0646\\u0648\\u0627\\u0646 \\u0627\\u0644\\u0625\\u062e\\u062a\\u0628\\u0627\\u0631","enter_value_in_minutes":"\\u0623\\u062f\\u062e\\u0644 \\u0627\\u0644\\u0642\\u064a\\u0645\\u0629 \\u0641\\u064a \\u062f\\u0642\\u0627\\u0626\\u0642","it_will_be_updated_by_adding_the_questions":"\\u0641\\u0633\\u064a\\u062a\\u0645 \\u062a\\u062d\\u062f\\u064a\\u062b\\u0647 \\u0628\\u0625\\u0636\\u0627\\u0641\\u0629 \\u0623\\u0633\\u0626\\u0644\\u0629","pass_percentage":"\\u062a\\u0645\\u0631\\u064a\\u0631 \\u0627\\u0644\\u0646\\u0633\\u0628\\u0629 \\u0627\\u0644\\u0645\\u0626\\u0648\\u064a\\u0629","no":"\\u0644\\u0627","yes":"\\u0646\\u0639\\u0645 \\u0641\\u0639\\u0644\\u0627","description":"\\u0648\\u0635\\u0641","language":"\\u0644\\u063a\\u0629","code":"\\u0631\\u0645\\u0632","is_rtl":"\\u063a\\u064a\\u0631 RTL","default_language":"\\u0627\\u0644\\u0644\\u063a\\u0629 \\u0627\\u0644\\u0627\\u0641\\u062a\\u0631\\u0627\\u0636\\u064a\\u0629","enable":"\\u062a\\u0645\\u0643\\u064a\\u0646","disable":"\\u062a\\u0639\\u0637\\u064a\\u0644","set_default":"\\u0627\\u0644\\u0648\\u0636\\u0639 \\u0627\\u0644\\u0625\\u0641\\u062a\\u0631\\u0627\\u0636\\u064a","success":"\\u0646\\u062c\\u0627\\u062d","record_updated_successfully":"\\u0633\\u062c\\u0644 \\u0627\\u0644\\u062a\\u062d\\u062f\\u064a\\u062b \\u0628\\u0646\\u062c\\u0627\\u062d","deleted":"Deleted","sorry":"Sorry","cannot_delete_this_record_as":"Cannot Delete This Record As","add_user":"\\u0625\\u0636\\u0627\\u0641\\u0629 \\u0645\\u0633\\u062a\\u062e\\u062f\\u0645","name":"\\u0627\\u0633\\u0645","image":"\\u0635\\u0648\\u0631\\u0629","role":"\\u062f\\u0648\\u0631","update_details":"\\u062a\\u0641\\u0627\\u0635\\u064a\\u0644 \\u0627\\u0644\\u062a\\u062d\\u062f\\u064a\\u062b","view":"\\u0631\\u0623\\u064a","this_field_is_required":"\\u0647\\u0630\\u0647 \\u0627\\u0644\\u062e\\u0627\\u0646\\u0629 \\u0645\\u0637\\u0644\\u0648\\u0628\\u0647","please_enter_valid_email":"\\u0627\\u0644\\u0631\\u062c\\u0627\\u0621 \\u0625\\u062f\\u062e\\u0627\\u0644 \\u0628\\u0631\\u064a\\u062f \\u0625\\u0644\\u0643\\u062a\\u0631\\u0648\\u0646\\u064a \\u0635\\u062d\\u064a\\u062d","the_text_is_too_short":"\\u0646\\u0635 \\u0642\\u0635\\u064a\\u0631 \\u0644\\u0644\\u063a\\u0627\\u064a\\u0629","settings":"","exam_series":"\\u0633\\u0644\\u0633\\u0644\\u0629 \\u0627\\u0644\\u0627\\u0645\\u062a\\u062d\\u0627\\u0646","instructions":"\\u062a\\u0639\\u0644\\u064a\\u0645\\u0627\\u062a","coupons":"\\u0643\\u0648\\u0628\\u0648\\u0646\\u0627\\u062a","contents":"\\u0645\\u062d\\u062a\\u0648\\u064a\\u0627\\u062a","series":"\\u0633\\u0644\\u0633\\u0644\\u0629","notifications":"\\u0627\\u0644\\u0625\\u0634\\u0639\\u0627\\u0631\\u0627\\u062a","messages":"\\u0631\\u0633\\u0627\\u0626\\u0644","feedback":"\\u0631\\u062f\\u0648\\u062f \\u0627\\u0644\\u0641\\u0639\\u0644","update_strings":"\\u062a\\u062d\\u062f\\u064a\\u062b \\u0633\\u0644\\u0627\\u0633\\u0644","lms_categories":"LMS \\u0627\\u0644\\u0641\\u0626\\u0627\\u062a","update":"\\u062a\\u062d\\u062f\\u064a\\u062b","import_excel":"\\u0627\\u0633\\u062a\\u064a\\u0631\\u0627\\u062f \\u0625\\u0643\\u0633\\u0644","start_date":"\\u062a\\u0627\\u0631\\u064a\\u062e \\u0627\\u0644\\u0628\\u062f\\u0621","end_date":"\\u062a\\u0627\\u0631\\u064a\\u062e \\u0627\\u0644\\u0627\\u0646\\u062a\\u0647\\u0627\\u0621","url":"\\u0631\\u0627\\u0628\\u0637","couponcodes":"Couponcodes","discount":"\\u062e\\u0635\\u0645","minimum_bill":"\\u0628\\u064a\\u0644 \\u0627\\u0644\\u062d\\u062f \\u0627\\u0644\\u0623\\u062f\\u0646\\u0649","maximum_discount":"\\u0627\\u0644\\u062e\\u0635\\u0645 \\u0627\\u0644\\u0623\\u0642\\u0635\\u0649","limit":"\\u062d\\u062f","status":"\\u0627\\u0644\\u062d\\u0627\\u0644\\u0629","edit_user":"\\u062a\\u062d\\u0631\\u064a\\u0631 \\u0627\\u0644\\u0639\\u0636\\u0648","the_text_is_too_long":"\\u0627\\u0644\\u0646\\u0635 \\u0637\\u0648\\u064a\\u0644 \\u062c\\u062f\\u0627","invalid_input":"\\u0645\\u062f\\u062e\\u0644 \\u063a\\u064a\\u0631 \\u0635\\u0627\\u0644\\u062d","select_role":"\\u062d\\u062f\\u062f \\u062f\\u0648\\u0631","add_language":"\\u0625\\u0636\\u0627\\u0641\\u0629 \\u0627\\u0644\\u0644\\u063a\\u0629","language_title":"\\u0627\\u0644\\u0639\\u0646\\u0648\\u0627\\u0646 \\u0627\\u0644\\u0644\\u063a\\u0629","language_code":"\\u0643\\u0648\\u062f \\u0627\\u0644\\u0644\\u063a\\u0629","supported_language_codes":"\\u0631\\u0645\\u0648\\u0632 \\u0644\\u063a\\u0629 \\u0645\\u0639\\u062a\\u0645\\u062f\\u0629","edit_language":"\\u062a\\u062d\\u0631\\u064a\\u0631 \\u0627\\u0644\\u0644\\u063a\\u0629","add_users":"\\u0625\\u0636\\u0627\\u0641\\u0629 \\u0645\\u0633\\u062a\\u062e\\u062f\\u0645\\u064a\\u0646","create_category":"\\u0625\\u0646\\u0634\\u0627\\u0621 \\u0627\\u0644\\u0641\\u0626\\u0629","category_name":"\\u0627\\u0633\\u0645 \\u0627\\u0644\\u062a\\u0635\\u0646\\u064a\\u0641","please_upload_valid_image_type":"\\u064a\\u0631\\u062c\\u0649 \\u062a\\u062d\\u0645\\u064a\\u0644 \\u0635\\u0627\\u0644\\u062d \\u0646\\u0648\\u0639 \\u0627\\u0644\\u0635\\u0648\\u0631\\u0629","edit_author":"\\u0627\\u0644\\u0643\\u0627\\u062a\\u0628 \\u062a\\u062d\\u0631\\u064a\\u0631","question_subjects":"\\u0627\\u0644\\u0645\\u0648\\u0636\\u0648\\u0639\\u0627\\u062a \\u0627\\u0644\\u0633\\u0624\\u0627\\u0644","add_subject":"\\u0625\\u0636\\u0627\\u0641\\u0629 \\u0627\\u0644\\u0645\\u0648\\u0636\\u0648\\u0639","subject":"\\u0645\\u0648\\u0636\\u0648\\u0639","view_questions":"\\u0639\\u0631\\u0636 \\u0627\\u0644\\u0623\\u0633\\u0626\\u0644\\u0629","subject_title":"\\u064a\\u062e\\u0636\\u0639 \\u0639\\u0646\\u0648\\u0627\\u0646","subject_code":"\\u0631\\u0645\\u0632 \\u0627\\u0644\\u0645\\u0648\\u0636\\u0648\\u0639","is_lab":"\\u0647\\u0648 \\u0645\\u062e\\u062a\\u0628\\u0631","is_elective":"\\u063a\\u064a\\u0631 \\u0627\\u0644\\u0627\\u062e\\u062a\\u064a\\u0627\\u0631\\u064a\\u0629","maximum_marks":"\\u0627\\u0644\\u0639\\u0644\\u0627\\u0645\\u0627\\u062a \\u0627\\u0644\\u0642\\u0635\\u0648\\u0649","please_enter_valid_number":"\\u0627\\u0644\\u0631\\u062c\\u0627\\u0621 \\u0625\\u062f\\u062e\\u0627\\u0644 \\u0635\\u0627\\u0644\\u062d \\u0639\\u062f\\u062f","pass_marks":"\\u0639\\u0644\\u0627\\u0645\\u0629 \\u0645\\u0631\\u0648\\u0631","please_enter_valid_maximum_marks":"\\u0627\\u0644\\u0631\\u062c\\u0627\\u0621 \\u0625\\u062f\\u062e\\u0627\\u0644 \\u0627\\u0644\\u0639\\u0644\\u0627\\u0645\\u0627\\u062a \\u0627\\u0644\\u0642\\u0635\\u0648\\u0649 \\u0635\\u0627\\u0644\\u062d","please_enter_valid_pass_marks":"\\u0627\\u0644\\u0631\\u062c\\u0627\\u0621 \\u0625\\u062f\\u062e\\u0627\\u0644 \\u0639\\u0644\\u0627\\u0645\\u0627\\u062a \\u0627\\u0644\\u0646\\u062c\\u0627\\u062d \\u0635\\u0627\\u0644\\u062d\\u0629","pass_marks_cannot_be_greater_than_maximum_marks":"\\u0639\\u0644\\u0627\\u0645\\u0627\\u062a \\u0627\\u0644\\u0646\\u062c\\u0627\\u062d \\u0644\\u0627 \\u064a\\u0645\\u0643\\u0646 \\u0623\\u0646 \\u062a\\u0643\\u0648\\u0646 \\u0623\\u0643\\u0628\\u0631 \\u0645\\u0646 \\u0627\\u0644\\u0639\\u0644\\u0627\\u0645\\u0627\\u062a \\u0627\\u0644\\u0642\\u0635\\u0648\\u0649","topic":"\\u0645\\u0648\\u0636\\u0648\\u0639","question":"\\u0633\\u0624\\u0627\\u0644","difficulty":"\\u0635\\u0639\\u0648\\u0628\\u0629","subjects_list":"\\u0642\\u0627\\u0626\\u0645\\u0629 \\u0627\\u0644\\u0645\\u0648\\u0636\\u0648\\u0639\\u0627\\u062a","max_marks":"\\u0645\\u0627\\u0631\\u0643\\u0633 \\u0645\\u0627\\u0643\\u0633","topics_list":"\\u0642\\u0627\\u0626\\u0645\\u0629 \\u0627\\u0644\\u0645\\u0648\\u0627\\u0636\\u064a\\u0639","parent":"\\u0623\\u0635\\u0644","from_email":"\\u0645\\u0646 \\u0627\\u0644\\u0628\\u0631\\u064a\\u062f \\u0627\\u0644\\u0625\\u0644\\u0643\\u062a\\u0631\\u0648\\u0646\\u0649","from_name":"\\u0645\\u0646 \\u0627\\u0644\\u0627\\u0633\\u0645","module":"\\u0648\\u062d\\u062f\\u0629","key":"\\u0645\\u0641\\u062a\\u0627\\u062d","add_setting":"\\u0625\\u0636\\u0627\\u0641\\u0629 \\u0648\\u0636\\u0639","edit_topic":"\\u062a\\u062d\\u0631\\u064a\\u0631 \\u0627\\u0644\\u0645\\u0648\\u0636\\u0648\\u0639","select_parent":"\\u062d\\u062f\\u062f \\u0627\\u0644\\u0631\\u0626\\u064a\\u0633\\u064a","topic_name":"\\u0627\\u0633\\u0645 \\u0627\\u0644\\u0645\\u0648\\u0636\\u0648\\u0639","edit_template":"\\u062a\\u062d\\u0631\\u064a\\u0631 \\u0642\\u0627\\u0644\\u0628","welcome":"\\u0623\\u0647\\u0644\\u0627 \\u0628\\u0643","are_you_sure":"\\u0647\\u0644 \\u0623\\u0646\\u062a \\u0648\\u0627\\u062b\\u0642","you_will_not_be_able_to_recover_this_record":"\\u0623\\u0646\\u062a \\u0644\\u0646 \\u062a\\u0643\\u0648\\u0646 \\u0642\\u0627\\u062f\\u0631\\u0629 \\u0639\\u0644\\u0649 \\u0627\\u0633\\u062a\\u0631\\u062f\\u0627\\u062f \\u0647\\u0630\\u0627 \\u0627\\u0644\\u0633\\u062c\\u0644","delete_it":"\\u0627\\u062d\\u0630\\u0641\\u0647","cancel_please":"\\u0625\\u0644\\u063a\\u0627\\u0621 \\u0627\\u0644\\u0631\\u062c\\u0627\\u0621","your_record_has_been_deleted":"\\u062a\\u0633\\u062c\\u064a\\u0644 \\u062a\\u0645 \\u062d\\u0630\\u0641","cancelled":"\\u062a\\u0645 \\u0627\\u0644\\u0627\\u0644\\u063a\\u0627\\u0621","your_record_is_safe":"\\u062a\\u0633\\u062c\\u064a\\u0644 \\u0622\\u0645\\u0646\\u0629","payment_reports":"\\u062a\\u0642\\u0627\\u0631\\u064a\\u0631 \\u0627\\u0644\\u062f\\u0641\\u0639","online_payments":"\\u0627\\u0644\\u0645\\u062f\\u0641\\u0648\\u0639\\u0627\\u062a \\u0639\\u0628\\u0631 \\u0627\\u0644\\u0625\\u0646\\u062a\\u0631\\u0646\\u062a","offline_payments":"\\u0627\\u0644\\u0645\\u062f\\u0641\\u0648\\u0639\\u0627\\u062a \\u062d\\u0627\\u0644\\u064a\\u0627","export":"\\u062a\\u0635\\u062f\\u064a\\u0631","sms":"\\u0631\\u0633\\u0627\\u0644\\u0629 \\u0642\\u0635\\u064a\\u0631\\u0629"}', '2016-08-18 00:10:49', '2016-10-19 19:26:39');
INSERT INTO `languages` (`id`, `language`, `slug`, `code`, `is_rtl`, `is_default`, `phrases`, `created_at`, `updated_at`) VALUES
(6, 'Tamil', 'tamil', 'ta', 0, 0, '{"success":"\\u0bb5\\u0bc6\\u0bb1\\u0bcd\\u0bb1\\u0bbf","record_updated_successfully":"\\u0baa\\u0ba4\\u0bbf\\u0bb5\\u0bc1 \\u0bb5\\u0bc6\\u0bb1\\u0bcd\\u0bb1\\u0bbf\\u0b95\\u0bb0\\u0bae\\u0bbe\\u0b95 \\u0baa\\u0bc1\\u0ba4\\u0bc1\\u0baa\\u0bcd\\u0baa\\u0bbf\\u0b95\\u0bcd\\u0b95\\u0baa\\u0bcd\\u0baa\\u0b9f\\u0bcd\\u0b9f\\u0ba4\\u0bc1","languages":"\\u0bae\\u0bc6\\u0bbe\\u0bb4\\u0bbf\\u0b95\\u0bb3\\u0bcd","create":"\\u0b89\\u0bb0\\u0bc1\\u0bb5\\u0bbe\\u0b95\\u0bcd\\u0b95\\u0bc1","language":"\\u0bae\\u0bc6\\u0bbe\\u0bb4\\u0bbf","code":"\\u0b95\\u0bc1\\u0bb1\\u0bbf\\u0baf\\u0bc0\\u0b9f\\u0bc1","is_rtl":"\\u0bb5\\u0bb2\\u0bae\\u0bbf\\u0bb0\\u0bc1\\u0ba8\\u0bcd\\u0ba4\\u0bc1 \\u0b87\\u0b9f\\u0bae\\u0bbe\\u0b95 \\u0b87\\u0bb0\\u0bc1\\u0b95\\u0bcd\\u0b95\\u0bbf\\u0bb1\\u0ba4\\u0bc1","default_language":"\\u0b87\\u0baf\\u0bb2\\u0bcd\\u0baa\\u0bc1\\u0ba8\\u0bbf\\u0bb2\\u0bc8 \\u0bae\\u0bc6\\u0bbe\\u0bb4\\u0bbf","action":"\\u0b85\\u0ba4\\u0bbf\\u0bb0\\u0b9f\\u0bbf","deleted":"\\u0ba8\\u0bc0\\u0b95\\u0bcd\\u0b95\\u0baa\\u0bcd\\u0baa\\u0b9f\\u0bcd\\u0b9f","sorry":"\\u0bae\\u0ba9\\u0bcd\\u0ba9\\u0bbf\\u0b95\\u0bcd\\u0b95\\u0bb5\\u0bc1\\u0bae\\u0bcd","cannot_delete_this_record_as":"\\u0b87\\u0ba8\\u0bcd\\u0ba4 \\u0b9a\\u0bbe\\u0ba4\\u0ba9\\u0bc8\\u0baf\\u0bc8 \\u0baa\\u0bc7\\u0bbe\\u0bb2\\u0bcd \\u0ba8\\u0bc0\\u0b95\\u0bcd\\u0b95 \\u0bae\\u0bc1\\u0b9f\\u0bbf\\u0baf\\u0bbe\\u0ba4\\u0bc1","site_title":"\\u0ba4\\u0bb3 \\u0ba4\\u0bb2\\u0bc8\\u0baa\\u0bcd\\u0baa\\u0bc1","latest_users":"\\u0b9a\\u0bae\\u0bc0\\u0baa\\u0ba4\\u0bcd\\u0ba4\\u0bbf\\u0baf \\u0baa\\u0baf\\u0ba9\\u0bb0\\u0bcd\\u0b95\\u0bb3\\u0bcd","was_joined_as":"\\u0b8e\\u0ba9 \\u0b87\\u0ba3\\u0bc8\\u0ba8\\u0bcd\\u0ba4\\u0bc1 \\u0b95\\u0bc6\\u0bbe\\u0ba3\\u0bcd\\u0b9f\\u0ba9\\u0bb0\\u0bcd","see_more":"\\u0bae\\u0bc7\\u0bb2\\u0bc1\\u0bae\\u0bcd \\u0baa\\u0bbe\\u0bb0\\u0bcd\\u0b95\\u0bcd\\u0b95","my_profile":"\\u0b8e\\u0ba9\\u0bcd \\u0b9a\\u0bc1\\u0baf\\u0bb5\\u0bbf\\u0bb5\\u0bb0\\u0bae\\u0bcd","change_password":"\\u0b95\\u0b9f\\u0bb5\\u0bc1\\u0b9a\\u0bcd\\u0b9a\\u0bc6\\u0bbe\\u0bb2\\u0bcd\\u0bb2\\u0bc8 \\u0bae\\u0bbe\\u0bb1\\u0bcd\\u0bb1\\u0bc1","logout":"\\u0bb5\\u0bc6\\u0bb3\\u0bbf\\u0baf\\u0bc7\\u0bb1\\u0bc1","dashboard":"\\u0b9f\\u0bbe\\u0bb7\\u0bcd\\u0baa\\u0bc7\\u0bbe\\u0bb0\\u0bcd\\u0b9f\\u0bc1","users":"\\u0baa\\u0baf\\u0ba9\\u0bb0\\u0bcd\\u0b95\\u0bb3\\u0bcd","roles":"\\u0baa\\u0bbe\\u0ba4\\u0bcd\\u0ba4\\u0bbf\\u0bb0\\u0b99\\u0bcd\\u0b95\\u0bb3\\u0bcd","fee_settings":"\\u0b95\\u0b9f\\u0bcd\\u0b9f\\u0ba3\\u0bae\\u0bcd \\u0b85\\u0bae\\u0bc8\\u0baa\\u0bcd\\u0baa\\u0bc1\\u0b95\\u0bb3\\u0bcd","fee_categories":"\\u0b95\\u0b9f\\u0bcd\\u0b9f\\u0ba3\\u0bae\\u0bcd \\u0bb5\\u0b95\\u0bc8\\u0b95\\u0bb3\\u0bcd","fee_category_allotment":"\\u0b95\\u0b9f\\u0bcd\\u0b9f\\u0ba3\\u0bae\\u0bcd \\u0baa\\u0b95\\u0bc1\\u0baa\\u0bcd\\u0baa\\u0bc1 \\u0b92\\u0ba4\\u0bc1\\u0b95\\u0bcd\\u0b95\\u0bc0\\u0b9f\\u0bc1","fee_particulars":"\\u0b95\\u0b9f\\u0bcd\\u0b9f\\u0ba3\\u0bae\\u0bcd \\u0bb5\\u0bbf\\u0baa\\u0bb0\\u0b99\\u0bcd\\u0b95\\u0bb3\\u0bcd","fee_schedules":"\\u0b95\\u0b9f\\u0bcd\\u0b9f\\u0ba3\\u0bae\\u0bcd \\u0bb5\\u0bbf\\u0bae\\u0bbe\\u0ba9 \\u0b95\\u0bbe\\u0bb2 \\u0b85\\u0b9f\\u0bcd\\u0b9f\\u0bb5\\u0ba3\\u0bc8\\u0b95\\u0bb3\\u0bcd","fines":"\\u0b85\\u0baa\\u0bb0\\u0bbe\\u0ba4\\u0bae\\u0bcd","discounts":"\\u0ba4\\u0bb3\\u0bcd\\u0bb3\\u0bc1\\u0baa\\u0b9f\\u0bbf\\u0b95\\u0bb3\\u0bcd","master_settings":"\\u0bae\\u0bbe\\u0bb8\\u0bcd\\u0b9f\\u0bb0\\u0bcd \\u0b85\\u0bae\\u0bc8\\u0baa\\u0bcd\\u0baa\\u0bc1\\u0b95\\u0bb3\\u0bcd","religions_master":"\\u0bae\\u0ba4\\u0b99\\u0bcd\\u0b95\\u0bb3\\u0bcd \\u0bae\\u0bbe\\u0bb8\\u0bcd\\u0b9f\\u0bb0\\u0bcd","academics_master":"\\u0b95\\u0bb2\\u0bcd\\u0bb5\\u0bbf\\u0baf\\u0bbe\\u0bb3\\u0bb0\\u0bcd\\u0b95\\u0bb3\\u0bcd \\u0bae\\u0bbe\\u0bb8\\u0bcd\\u0b9f\\u0bb0\\u0bcd","courses_master":"\\u0bae\\u0bc8\\u0ba4\\u0bbe\\u0ba9\\u0b99\\u0bcd\\u0b95\\u0bb3\\u0bcd \\u0bae\\u0bbe\\u0bb8\\u0bcd\\u0b9f\\u0bb0\\u0bcd","subjects_master":"\\u0baa\\u0bbe\\u0b9f\\u0b99\\u0bcd\\u0b95\\u0bb3\\u0bcd \\u0bae\\u0bbe\\u0bb8\\u0bcd\\u0b9f\\u0bb0\\u0bcd","subject_topics":"\\u0baa\\u0bc6\\u0bbe\\u0bb0\\u0bc1\\u0bb3\\u0bcd \\u0ba4\\u0bb2\\u0bc8\\u0baa\\u0bcd\\u0baa\\u0bc1\\u0b95\\u0bb3\\u0bcd","course_subjects":"\\u0baa\\u0bbe\\u0b9f\\u0ba4\\u0bcd\\u0ba4\\u0bbf\\u0b9f\\u0bcd\\u0b9f\\u0b99\\u0bcd\\u0b95\\u0bb3\\u0bc8","email_templates":"\\u0bae\\u0bbf\\u0ba9\\u0bcd\\u0ba9\\u0b9e\\u0bcd\\u0b9a\\u0bb2\\u0bcd \\u0bb5\\u0bbe\\u0bb0\\u0bcd\\u0baa\\u0bcd\\u0baa\\u0bc1","exams":"\\u0ba4\\u0bc7\\u0bb0\\u0bcd\\u0bb5\\u0bc1\\u0b95\\u0bb3\\u0bcd","categories":"\\u0bb5\\u0b95\\u0bc8\\u0b95\\u0bb3\\u0bcd","question_bank":"\\u0b95\\u0bc7\\u0bb3\\u0bcd\\u0bb5\\u0bbf \\u0bb5\\u0b99\\u0bcd\\u0b95\\u0bbf","quiz":"\\u0bb5\\u0bbf\\u0ba9\\u0bbe\\u0b9f\\u0bbf \\u0bb5\\u0bbf\\u0ba9\\u0bbe","lms":"LMS","content":"\\u0b89\\u0bb3\\u0bcd\\u0bb3\\u0b9f\\u0b95\\u0bcd\\u0b95","study_materials":"\\u0b86\\u0baf\\u0bcd\\u0bb5\\u0bc1 \\u0baa\\u0bc6\\u0bbe\\u0bb0\\u0bc1\\u0b9f\\u0bcd\\u0b95\\u0bb3\\u0bcd","library":"\\u0ba8\\u0bc2\\u0bb2\\u0b95\\u0bae\\u0bcd","asset_types":"\\u0b9a\\u0bc6\\u0bbe\\u0ba4\\u0bcd\\u0ba4\\u0bc1 \\u0bb5\\u0b95\\u0bc8\\u0b95\\u0bb3\\u0bcd","master_data":"\\u0baa\\u0bbf\\u0bb0\\u0ba4\\u0bbe\\u0ba9 \\u0ba4\\u0bb0\\u0bb5\\u0bc1","publishers":"\\u0baa\\u0baa\\u0bcd\\u0bb3\\u0bbf\\u0bb7\\u0bb0\\u0bcd\\u0bb8\\u0bcd","authors":"\\u0b86\\u0b9a\\u0bbf\\u0bb0\\u0bbf\\u0baf\\u0bb0\\u0bcd\\u0b95\\u0bb3\\u0bcd","students":"\\u0bae\\u0bbe\\u0ba3\\u0bb5\\u0bb0\\u0bcd\\u0b95\\u0bb3\\u0bcd","staff":"\\u0b8a\\u0bb4\\u0bbf\\u0baf\\u0bb0\\u0bcd\\u0b95\\u0bb3\\u0bcd","school_hub":"\\u0baa\\u0bb3\\u0bcd\\u0bb3\\u0bbf \\u0bae\\u0bc8\\u0baf\\u0bae\\u0bcd","attendance":"\\u0bb5\\u0bb0\\u0bc1\\u0b95\\u0bc8","edit":"\\u0ba4\\u0bc6\\u0bbe\\u0b95\\u0bc1","delete":"\\u0b85\\u0bb4\\u0bbf","enable":"\\u0b87\\u0baf\\u0b95\\u0bcd\\u0b95\\u0bc1","set_default":"\\u0b87\\u0baf\\u0bb2\\u0bcd\\u0baa\\u0bbe\\u0b95 \\u0b85\\u0bae\\u0bc8","disable":"\\u0bae\\u0bc1\\u0b9f\\u0b95\\u0bcd\\u0b95\\u0bc1","user_statistics":"\\u0baa\\u0baf\\u0ba9\\u0bb0\\u0bcd \\u0baa\\u0bc1\\u0bb3\\u0bcd\\u0bb3\\u0bbf \\u0bb5\\u0bbf\\u0baa\\u0bb0\\u0b99\\u0bcd\\u0b95\\u0bb3\\u0bcd","view_all":"\\u0b95\\u0bbe\\u0ba3\\u0bcd\\u0b95 \\u0b85\\u0ba9\\u0bc8\\u0ba4\\u0bcd\\u0ba4\\u0bc1","quiz_categories":"\\u0bb5\\u0bbf\\u0ba9\\u0bbe\\u0b9f\\u0bbf \\u0bb5\\u0bbf\\u0ba9\\u0bbe \\u0bb5\\u0b95\\u0bc8\\u0b95\\u0bb3\\u0bcd","quizzes":"\\u0bb5\\u0bbf\\u0ba9\\u0bbe\\u0bb5\\u0bbf\\u0b9f\\u0bc8","subjects":"\\u0baa\\u0bbe\\u0b9f\\u0b99\\u0bcd\\u0b95\\u0bb3\\u0bcd","topics":"\\u0ba4\\u0bb2\\u0bc8\\u0baa\\u0bcd\\u0baa\\u0bc1\\u0b95\\u0bb3\\u0bcd","questions":"\\u0b95\\u0bc7\\u0bb3\\u0bcd\\u0bb5\\u0bbf\\u0b95\\u0bb3\\u0bcd","home":"\\u0bae\\u0bc1\\u0b95\\u0baa\\u0bcd\\u0baa\\u0bc1","faqs":"\\u0b95\\u0bc7\\u0bb3\\u0bcd\\u0bb5\\u0bbf \\u0baa\\u0ba4\\u0bbf\\u0bb2\\u0bcd","about_us":"\\u0b8e\\u0b99\\u0bcd\\u0b95\\u0bb3\\u0bc8 \\u0baa\\u0bb1\\u0bcd\\u0bb1\\u0bbf","contact_us":"\\u0b8e\\u0b99\\u0bcd\\u0b95\\u0bb3\\u0bc8 \\u0ba4\\u0bc6\\u0bbe\\u0b9f\\u0bb0\\u0bcd\\u0baa\\u0bc1","email":"\\u0bae\\u0bbf\\u0ba9\\u0bcd\\u0ba9\\u0b9e\\u0bcd\\u0b9a\\u0bb2\\u0bcd","password":"\\u0b95\\u0b9f\\u0bb5\\u0bc1\\u0b9a\\u0bcd\\u0b9a\\u0bc6\\u0bbe\\u0bb2\\u0bcd","login":"\\u0b89\\u0bb3\\u0bcd \\u0ba8\\u0bc1\\u0bb4\\u0bc8","forgot_password":"\\u0b95\\u0b9f\\u0bb5\\u0bc1\\u0b9a\\u0bcd\\u0b9a\\u0bc6\\u0bbe\\u0bb2\\u0bcd \\u0bae\\u0bb1\\u0ba8\\u0bcd\\u0ba4\\u0bc1 \\u0bb5\\u0bbf\\u0b9f\\u0bcd\\u0b9f\\u0bc0\\u0bb0\\u0bcd\\u0b95\\u0bb3\\u0bbe","register":"\\u0baa\\u0ba4\\u0bbf\\u0bb5\\u0bc1","this_field_id_required":"\\u0b87\\u0ba8\\u0bcd\\u0ba4 \\u0ba4\\u0bc1\\u0bb1\\u0bc8\\u0baf\\u0bbf\\u0bb2\\u0bcd \\u0b90\\u0b9f\\u0bbf \\u0ba4\\u0bc7\\u0bb5\\u0bc8","please_enter_valid_email":"\\u0b9a\\u0bb0\\u0bbf\\u0baf\\u0bbe\\u0ba9 \\u0bae\\u0bbf\\u0ba9\\u0bcd\\u0ba9\\u0b9e\\u0bcd\\u0b9a\\u0bb2\\u0bc8 \\u0b89\\u0bb3\\u0bcd\\u0bb3\\u0bbf\\u0b9f\\u0bb5\\u0bc1\\u0bae\\u0bcd","this_field_is_required":"\\u0b87\\u0ba8\\u0bcd\\u0ba4 \\u0ba4\\u0bc1\\u0bb1\\u0bc8\\u0baf\\u0bbf\\u0bb2\\u0bcd \\u0ba4\\u0bc7\\u0bb5\\u0bc8","the_text_is_too_short":"\\u0b89\\u0bb0\\u0bc8 \\u0bae\\u0bbf\\u0b95\\u0bb5\\u0bc1\\u0bae\\u0bcd \\u0b9a\\u0bbf\\u0bb1\\u0bbf\\u0baf\\u0ba4\\u0bbe\\u0b95 \\u0b89\\u0bb3\\u0bcd\\u0bb3\\u0ba4\\u0bc1","settings":"","are_you_sure":"\\u0ba8\\u0bc0 \\u0b9a\\u0bc6\\u0bbe\\u0bb2\\u0bcd\\u0bb5\\u0ba4\\u0bc1 \\u0b89\\u0bb1\\u0bc1\\u0ba4\\u0bbf\\u0baf\\u0bbe","you_will_not_be_able_to_recover_this_record":"\\u0b87\\u0ba8\\u0bcd\\u0ba4\\u0baa\\u0bcd \\u0baa\\u0ba4\\u0bbf\\u0bb5\\u0bbf\\u0bb2\\u0bcd \\u0bae\\u0bc0\\u0b9f\\u0bcd\\u0b95 \\u0bae\\u0bc1\\u0b9f\\u0bbf\\u0baf\\u0bbe\\u0ba4\\u0bc1","yes":"\\u0b86\\u0bae\\u0bcd","delete_it":"\\u0ba8\\u0bc0\\u0b95\\u0bcd\\u0b95\\u0bc1","no":"\\u0b87\\u0bb2\\u0bcd\\u0bb2\\u0bc8","cancel_please":"\\u0bb0\\u0ba4\\u0bcd\\u0ba4\\u0bc1 \\u0b9a\\u0bc6\\u0baf\\u0bcd\\u0b95","your_record_has_been_deleted":"\\u0b89\\u0b99\\u0bcd\\u0b95\\u0bb3\\u0bcd \\u0baa\\u0ba4\\u0bbf\\u0bb5\\u0bc1 \\u0ba8\\u0bc0\\u0b95\\u0bcd\\u0b95\\u0baa\\u0bcd\\u0baa\\u0b9f\\u0bcd\\u0b9f\\u0ba4\\u0bc1","cancelled":"\\u0bb0\\u0ba4\\u0bcd\\u0ba4\\u0bc1","your_record_is_safe":"\\u0b89\\u0b99\\u0bcd\\u0b95\\u0bb3\\u0bcd \\u0b9a\\u0bbe\\u0ba4\\u0ba9\\u0bc8\\u0baf\\u0bc8 \\u0baa\\u0bbe\\u0ba4\\u0bc1\\u0b95\\u0bbe\\u0baa\\u0bcd\\u0baa\\u0bbe\\u0ba9\\u0ba4\\u0bc1","exam_series":"\\u0ba4\\u0bc7\\u0bb0\\u0bcd\\u0bb5\\u0bc1 \\u0ba4\\u0bc6\\u0bbe\\u0b9f\\u0bb0\\u0bcd","instructions":"\\u0bb5\\u0bb4\\u0bbf\\u0bae\\u0bc1\\u0bb1\\u0bc8\\u0b95\\u0bb3\\u0bcd","coupons":"\\u0b95\\u0bc2\\u0baa\\u0bcd\\u0baa\\u0ba9\\u0bcd\\u0b95\\u0bb3\\u0bcd","list":"\\u0baa\\u0b9f\\u0bcd\\u0b9f\\u0bbf\\u0baf\\u0bb2\\u0bcd","add":"\\u0b95\\u0bc2\\u0b9f\\u0bcd\\u0b9f\\u0bc1","contents":"\\u0baa\\u0bc6\\u0bbe\\u0bb0\\u0bc1\\u0bb3\\u0b9f\\u0b95\\u0bcd\\u0b95\\u0bae\\u0bcd","series":"\\u0ba4\\u0bc6\\u0bbe\\u0b9f\\u0bb0\\u0bcd","payment_reports":"\\u0b95\\u0bc6\\u0bbe\\u0b9f\\u0bc1\\u0baa\\u0bcd\\u0baa\\u0ba9\\u0bb5\\u0bc1 \\u0b85\\u0bb1\\u0bbf\\u0b95\\u0bcd\\u0b95\\u0bc8\\u0b95\\u0bb3\\u0bcd","online_payments":"\\u0b86\\u0ba9\\u0bcd\\u0bb2\\u0bc8\\u0ba9\\u0bcd \\u0b95\\u0bc6\\u0bbe\\u0b9f\\u0bc1\\u0baa\\u0bcd\\u0baa\\u0ba9\\u0bb5\\u0bc1","offline_payments":"\\u0ba8\\u0ba9\\u0bcd\\u0bb1\\u0bbf \\u0b9a\\u0bc6\\u0bb2\\u0bc1\\u0ba4\\u0bcd\\u0ba4\\u0bc1\\u0bae\\u0bcd","export":"\\u0b8f\\u0bb1\\u0bcd\\u0bb1\\u0bc1\\u0bae\\u0ba4\\u0bbf","notifications":"\\u0b85\\u0bb1\\u0bbf\\u0bb5\\u0bbf\\u0baa\\u0bcd\\u0baa\\u0bc1\\u0b95\\u0bb3\\u0bcd","sms":"\\u0b8e\\u0bb8\\u0bcd\\u0b8e\\u0bae\\u0bcd\\u0b8e\\u0bb8\\u0bcd","feedback":"\\u0b95\\u0bb0\\u0bc1\\u0ba4\\u0bcd\\u0ba4\\u0bc1","update_strings":"\\u0b9a\\u0bb0\\u0b99\\u0bcd\\u0b95\\u0bb3\\u0bc8 \\u0baa\\u0bc1\\u0ba4\\u0bc1\\u0baa\\u0bcd\\u0baa\\u0bbf\\u0b95\\u0bcd\\u0b95\\u0baa\\u0bcd\\u0baa\\u0b9f\\u0bcd\\u0b9f\\u0ba4\\u0bc1","create_series":"\\u0ba4\\u0bc6\\u0bbe\\u0b9f\\u0bb0\\u0bc8 \\u0b89\\u0bb0\\u0bc1\\u0bb5\\u0bbe\\u0b95\\u0bcd\\u0b95\\u0bc1","title":"\\u0ba4\\u0bb2\\u0bc8\\u0baa\\u0bcd\\u0baa\\u0bc1","duration":"\\u0b95\\u0bbe\\u0bb2\\u0bae\\u0bcd","category":"\\u0baa\\u0b95\\u0bc1\\u0baa\\u0bcd\\u0baa\\u0bc1","is_paid":"\\u0b9a\\u0bc6\\u0bb2\\u0bc1\\u0ba4\\u0bcd\\u0ba4\\u0baa\\u0bcd\\u0baa\\u0b9f\\u0bc1\\u0b95\\u0bbf\\u0bb1\\u0ba4\\u0bc1","total_marks":"\\u0bae\\u0bc6\\u0bbe\\u0ba4\\u0bcd\\u0ba4 \\u0bae\\u0ba4\\u0bbf\\u0baa\\u0bcd\\u0baa\\u0bc6\\u0ba3\\u0bcd\\u0b95\\u0bb3\\u0bcd","update_questions":"\\u0baa\\u0bc1\\u0ba4\\u0bc1\\u0baa\\u0bcd\\u0baa\\u0bbf\\u0b95\\u0bcd\\u0b95\\u0baa\\u0bcd\\u0baa\\u0b9f\\u0bcd\\u0b9f\\u0ba4\\u0bc1 \\u0b95\\u0bc7\\u0bb3\\u0bcd\\u0bb5\\u0bbf\\u0b95\\u0bb3\\u0bcd","free":"\\u0b87\\u0bb2\\u0bb5\\u0b9a","paid":"\\u0baa\\u0ba3\\u0bae\\u0bcd","create_quiz":"\\u0bb5\\u0bbf\\u0ba9\\u0bbe\\u0b9f\\u0bbf \\u0bb5\\u0bbf\\u0ba9\\u0bbe \\u0b89\\u0bb0\\u0bc1\\u0bb5\\u0bbe\\u0b95\\u0bcd\\u0b95\\u0bc1","quiz_title":"\\u0bb5\\u0bbf\\u0ba9\\u0bbe\\u0b9f\\u0bbf \\u0bb5\\u0bbf\\u0ba9\\u0bbe \\u0ba4\\u0bb2\\u0bc8\\u0baa\\u0bcd\\u0baa\\u0bc1","invalid_input":"\\u0ba4\\u0bb5\\u0bb1\\u0bbe\\u0ba9 \\u0b89\\u0bb3\\u0bcd\\u0bb3\\u0bc0\\u0b9f\\u0bc1","the_text_is_too_long":"\\u0b89\\u0bb0\\u0bc8 \\u0bae\\u0bbf\\u0b95\\u0bb5\\u0bc1\\u0bae\\u0bcd \\u0ba8\\u0bc0\\u0bb3\\u0bae\\u0bbe\\u0b95 \\u0b89\\u0bb3\\u0bcd\\u0bb3\\u0ba4\\u0bc1","enter_value_in_minutes":"\\u0bae\\u0ba4\\u0bbf\\u0baa\\u0bcd\\u0baa\\u0bc1 \\u0ba8\\u0bbf\\u0bae\\u0bbf\\u0b9f\\u0b99\\u0bcd\\u0b95\\u0bb3\\u0bcd \\u0b89\\u0bb3\\u0bcd\\u0bb3\\u0bbf\\u0b9f\\u0bb5\\u0bc1\\u0bae\\u0bcd","please_enter_valid_number":"\\u0ba4\\u0baf\\u0bb5\\u0bc1 \\u0b9a\\u0bc6\\u0baf\\u0bcd\\u0ba4\\u0bc1 \\u0b9a\\u0bb0\\u0bbf\\u0baf\\u0bbe\\u0ba9 \\u0b8e\\u0ba3\\u0bcd\\u0ba3\\u0bc8 \\u0b89\\u0bb3\\u0bcd\\u0bb3\\u0bbf\\u0b9f\\u0bb5\\u0bc1\\u0bae\\u0bcd","it will be updated by adding the questions":"\\u0b85\\u0ba4\\u0bc1 \\u0b95\\u0bc7\\u0bb3\\u0bcd\\u0bb5\\u0bbf\\u0b95\\u0bb3\\u0bcd \\u0b9a\\u0bc7\\u0bb0\\u0bcd\\u0baa\\u0bcd\\u0baa\\u0ba4\\u0ba9\\u0bcd \\u0bae\\u0bc2\\u0bb2\\u0bae\\u0bcd \\u0baa\\u0bc1\\u0ba4\\u0bc1\\u0baa\\u0bcd\\u0baa\\u0bbf\\u0b95\\u0bcd\\u0b95\\u0baa\\u0bcd\\u0baa\\u0b9f\\u0bc1\\u0bae\\u0bcd","pass_percentage":"\\u0ba4\\u0bc7\\u0bb0\\u0bcd\\u0b9a\\u0bcd\\u0b9a\\u0bbf \\u0b9a\\u0ba4\\u0bb5\\u0bc0\\u0ba4\\u0bae\\u0bcd","negative_mark":"\\u0b8e\\u0ba4\\u0bbf\\u0bb0\\u0bcd\\u0bae\\u0bb1\\u0bc8 \\u0bae\\u0bbe\\u0bb0\\u0bcd\\u0b95\\u0bcd","instructions_page":"\\u0bb5\\u0bb4\\u0bbf\\u0bae\\u0bc1\\u0bb1\\u0bc8\\u0b95\\u0bb3\\u0bcd \\u0baa\\u0b95\\u0bcd\\u0b95\\u0bae\\u0bcd","start_date":"\\u0ba4\\u0bc6\\u0bbe\\u0b9f\\u0b95\\u0bcd\\u0b95 \\u0ba4\\u0bc7\\u0ba4\\u0bbf","end_date":"\\u0b95\\u0b9f\\u0bc8\\u0b9a\\u0bbf \\u0ba4\\u0bc7\\u0ba4\\u0bbf","select":"\\u0ba4\\u0bc7\\u0bb0\\u0bcd\\u0bb5\\u0bc1","validity":"\\u0b8f\\u0bb1\\u0bcd\\u0bb1\\u0bc1\\u0b95\\u0bcd\\u0b95\\u0bc6\\u0bbe\\u0bb3\\u0bcd\\u0bb3\\u0b95\\u0bcd\\u0b95\\u0bc2\\u0b9f\\u0bbf\\u0baf","validity_in_days":"\\u0ba8\\u0bbe\\u0b9f\\u0bcd\\u0b95\\u0bb3\\u0bcd \\u0b8f\\u0bb1\\u0bcd\\u0bb1\\u0bc1\\u0b95\\u0bcd\\u0b95\\u0bc6\\u0bbe\\u0bb3\\u0bcd\\u0bb3\\u0b95\\u0bcd \\u0b95\\u0bc2\\u0b9f\\u0bbf\\u0baf","cost":"\\u0b9a\\u0bc6\\u0bb2\\u0bb5\\u0bc1","description":"\\u0bb5\\u0bbf\\u0bb3\\u0b95\\u0bcd\\u0b95\\u0bae\\u0bcd","update_questions_for":"\\u0bae\\u0bc7\\u0bae\\u0bcd\\u0baa\\u0b9f\\u0bc1\\u0ba4\\u0bcd\\u0ba4\\u0bb2\\u0bcd \\u0b95\\u0bc7\\u0bb3\\u0bcd\\u0bb5\\u0bbf\\u0b95\\u0bb3\\u0bcd","difficulty":"\\u0b95\\u0b9f\\u0bbf\\u0ba9\\u0bae\\u0bcd","easy":"\\u0b8e\\u0bb3\\u0bbf\\u0ba4\\u0bbe\\u0b95","medium":"\\u0ba8\\u0b9f\\u0bc1\\u0ba4\\u0bcd\\u0ba4\\u0bb0","hard":"\\u0bb9\\u0bbe\\u0bb0\\u0bcd\\u0b9f\\u0bcd","question_type":"\\u0b95\\u0bc7\\u0bb3\\u0bcd\\u0bb5\\u0bbf \\u0bb5\\u0b95\\u0bc8","single_answer":"\\u0b92\\u0bb1\\u0bcd\\u0bb1\\u0bc8 \\u0baa\\u0ba4\\u0bbf\\u0bb2\\u0bcd","multi_answer":"\\u0bae\\u0bb2\\u0bcd\\u0b9f\\u0bbf \\u0baa\\u0ba4\\u0bbf\\u0bb2\\u0bcd","fill_in_the_blanks":"\\u0bb5\\u0bc6\\u0bb1\\u0bcd\\u0bb1\\u0bbf\\u0b9f\\u0b99\\u0bcd\\u0b95\\u0bb3\\u0bc8 \\u0ba8\\u0bbf\\u0bb0\\u0baa\\u0bcd\\u0baa","match_the_following":"\\u0ba4\\u0bc6\\u0bbe\\u0b9f\\u0bb0\\u0bcd\\u0ba8\\u0bcd\\u0ba4\\u0bc1 \\u0bb5\\u0ba8\\u0bcd\\u0ba4 \\u0baa\\u0bc7\\u0bbe\\u0b9f\\u0bcd\\u0b9f\\u0bbf\\u0b95\\u0bcd\\u0b95\\u0bc1","paragraph":"\\u0baa\\u0ba4\\u0bcd\\u0ba4\\u0bbf","video":"\\u0b95\\u0bbe\\u0ba3\\u0bc6\\u0bbe\\u0bb3\\u0bbf","search_term":"\\u0ba4\\u0bc7\\u0b9f\\u0bb2\\u0bcd \\u0b95\\u0bbe\\u0bb2","enter_search_term":"\\u0ba4\\u0bc7\\u0b9f\\u0bb2\\u0bcd \\u0b9a\\u0bc6\\u0bbe\\u0bb2\\u0bcd\\u0bb2\\u0bc8 \\u0b89\\u0bb3\\u0bcd\\u0bb3\\u0bbf\\u0b9f\\u0bb5\\u0bc1\\u0bae\\u0bcd","subject":"\\u0baa\\u0bc6\\u0bbe\\u0bb0\\u0bc1\\u0bb3\\u0bcd","question":"\\u0b95\\u0bc7\\u0bb3\\u0bcd\\u0bb5\\u0bbf","type":"\\u0bb5\\u0b95\\u0bc8","marks":"\\u0bae\\u0ba4\\u0bbf\\u0baa\\u0bcd\\u0baa\\u0bc6\\u0ba3\\u0bcd\\u0b95\\u0bb3\\u0bcd","saved_questions":"\\u0b9a\\u0bc7\\u0bae\\u0bbf\\u0ba4\\u0bcd\\u0ba4 \\u0b95\\u0bc7\\u0bb3\\u0bcd\\u0bb5\\u0bbf\\u0b95\\u0bb3\\u0bcd","remove_all":"\\u0b85\\u0ba9\\u0bc8\\u0ba4\\u0bcd\\u0ba4\\u0bc1 \\u0ba8\\u0bc0\\u0b95\\u0bcd\\u0b95","update":"\\u0baa\\u0bc1\\u0ba4\\u0bc1\\u0baa\\u0bcd\\u0baa\\u0bbf\\u0b95\\u0bcd\\u0b95\\u0baa\\u0bcd\\u0baa\\u0b9f\\u0bcd\\u0b9f\\u0ba4\\u0bc1","import_excel":"\\u0b87\\u0bb1\\u0b95\\u0bcd\\u0b95\\u0bc1\\u0bae\\u0ba4\\u0bbf \\u0b8e\\u0b95\\u0bcd\\u0b9a\\u0bc6\\u0bb2\\u0bcd","add_user":"\\u0baa\\u0baf\\u0ba9\\u0bb0\\u0bcd \\u0b9a\\u0bc7\\u0bb0\\u0bcd\\u0b95\\u0bcd\\u0b95","name":"\\u0baa\\u0bc6\\u0baf\\u0bb0\\u0bcd","image":"\\u0baa\\u0b9f","role":"\\u0baa\\u0b99\\u0bcd\\u0b95\\u0bc1","import_users":"\\u0b87\\u0bb1\\u0b95\\u0bcd\\u0b95\\u0bc1\\u0bae\\u0ba4\\u0bbf \\u0baa\\u0baf\\u0ba9\\u0bb0\\u0bcd\\u0b95\\u0bb3\\u0bcd","download_template":"\\u0baa\\u0ba4\\u0bbf\\u0bb5\\u0bbf\\u0bb1\\u0b95\\u0bcd\\u0b95 \\u0b9f\\u0bc6\\u0bae\\u0bcd\\u0baa\\u0bcd\\u0bb3\\u0bc7\\u0b9f\\u0bcd","upload":"\\u0baa\\u0ba4\\u0bbf\\u0bb5\\u0bc7\\u0bb1\\u0bcd\\u0bb1\\u0bc1","upload_excel":"\\u0baa\\u0ba4\\u0bbf\\u0bb5\\u0bc7\\u0bb1\\u0bcd\\u0bb1\\u0bae\\u0bcd \\u0b8e\\u0b95\\u0bcd\\u0b9a\\u0bc6\\u0bb2\\u0bcd","file_type_not_allowed":"\\u0b95\\u0bc7\\u0bbe\\u0baa\\u0bcd\\u0baa\\u0bc1 \\u0bb5\\u0b95\\u0bc8 \\u0b85\\u0ba9\\u0bc1\\u0bae\\u0ba4\\u0bbf\\u0b95\\u0bcd\\u0b95\\u0baa\\u0bcd\\u0baa\\u0b9f\\u0bb5\\u0bbf\\u0bb2\\u0bcd\\u0bb2\\u0bc8","subjects_list":"\\u0baa\\u0bbe\\u0b9f\\u0b99\\u0bcd\\u0b95\\u0bb3\\u0bbf\\u0bb2\\u0bcd \\u0baa\\u0b9f\\u0bcd\\u0b9f\\u0bbf\\u0baf\\u0bb2\\u0bcd","import":"\\u0b87\\u0bb1\\u0b95\\u0bcd\\u0b95\\u0bc1\\u0bae\\u0ba4\\u0bbf","id":"\\u0b85\\u0b9f\\u0bc8\\u0baf\\u0bbe\\u0bb3\\u0bae\\u0bcd","max_marks":"\\u0bae\\u0bc7\\u0b95\\u0bcd\\u0bb8\\u0bcd \\u0bae\\u0bbe\\u0bb0\\u0bcd\\u0b95\\u0bcd\\u0bb8\\u0bcd","pass_marks":"\\u0baa\\u0bbe\\u0bb8\\u0bcd \\u0bae\\u0bbe\\u0bb0\\u0bcd\\u0b95\\u0bcd\\u0bb8\\u0bcd","total_exams":"\\u0bae\\u0bc6\\u0bbe\\u0ba4\\u0bcd\\u0ba4 \\u0ba4\\u0bc7\\u0bb0\\u0bcd\\u0bb5\\u0bc1\\u0b95\\u0bb3\\u0bcd","total_questions":"\\u0bae\\u0bc6\\u0bbe\\u0ba4\\u0bcd\\u0ba4 \\u0b95\\u0bc7\\u0bb3\\u0bcd\\u0bb5\\u0bbf\\u0b95\\u0bb3\\u0bcd","update_quizzes":"\\u0baa\\u0bc1\\u0ba4\\u0bc1\\u0baa\\u0bcd\\u0baa\\u0bbf\\u0b95\\u0bcd\\u0b95\\u0baa\\u0bcd\\u0baa\\u0b9f\\u0bcd\\u0b9f\\u0ba4\\u0bc1 \\u0bb5\\u0bbf\\u0ba9\\u0bbe\\u0bb5\\u0bbf\\u0b9f\\u0bc8","update_series_for":"\\u0baa\\u0bc1\\u0ba4\\u0bc1\\u0baa\\u0bcd\\u0baa\\u0bbf\\u0b95\\u0bcd\\u0b95\\u0baa\\u0bcd\\u0baa\\u0b9f\\u0bcd\\u0b9f\\u0ba4\\u0bc1 \\u0ba4\\u0bc6\\u0bbe\\u0b9f\\u0bb0\\u0bcd","exam_categories":"\\u0ba4\\u0bc7\\u0bb0\\u0bcd\\u0bb5\\u0bc1 \\u0bb5\\u0b95\\u0bc8\\u0b95\\u0bb3\\u0bcd","exam_name":"\\u0ba4\\u0bc7\\u0bb0\\u0bcd\\u0bb5\\u0bc1 \\u0baa\\u0bc6\\u0baf\\u0bb0\\u0bcd","saved_exams":"\\u0b9a\\u0bc7\\u0bae\\u0bbf\\u0ba4\\u0bcd\\u0ba4 \\u0ba4\\u0bc7\\u0bb0\\u0bcd\\u0bb5\\u0bc1\\u0b95\\u0bb3\\u0bcd","no_data_available":"\\u0ba4\\u0bb0\\u0bb5\\u0bc1 \\u0b8e\\u0ba4\\u0bc1\\u0bb5\\u0bc1\\u0bae\\u0bcd \\u0b95\\u0bbf\\u0b9f\\u0bc8\\u0b95\\u0bcd\\u0b95\\u0bb5\\u0bbf\\u0bb2\\u0bcd\\u0bb2\\u0bc8","couponcodes":"Couponcodes","discount":"\\u0ba4\\u0bb3\\u0bcd\\u0bb3\\u0bc1\\u0baa\\u0b9f\\u0bbf","minimum_bill":"\\u0b95\\u0bc1\\u0bb1\\u0bc8\\u0ba8\\u0bcd\\u0ba4\\u0baa\\u0b9f\\u0bcd\\u0b9a \\u0baa\\u0bbf\\u0bb2\\u0bcd","maximum_discount":"\\u0b85\\u0ba4\\u0bbf\\u0b95\\u0baa\\u0b9f\\u0bcd\\u0b9a \\u0ba4\\u0bb3\\u0bcd\\u0bb3\\u0bc1\\u0baa\\u0b9f\\u0bbf","limit":"\\u0b85\\u0bb3\\u0bb5\\u0bc1","status":"\\u0ba8\\u0bbf\\u0bb2\\u0bc8\\u0bae\\u0bc8","question_subjects":"\\u0b95\\u0bc7\\u0bb3\\u0bcd\\u0bb5\\u0bbf \\u0baa\\u0bbe\\u0b9f\\u0b99\\u0bcd\\u0b95\\u0bb3\\u0bcd","import_questions":"\\u0b87\\u0bb1\\u0b95\\u0bcd\\u0b95\\u0bc1\\u0bae\\u0ba4\\u0bbf \\u0b95\\u0bc7\\u0bb3\\u0bcd\\u0bb5\\u0bbf\\u0b95\\u0bb3\\u0bcd","add_subject":"\\u0baa\\u0bc6\\u0bbe\\u0bb0\\u0bc1\\u0bb3\\u0bcd \\u0b9a\\u0bc7\\u0bb0\\u0bcd","view_questions":"\\u0b95\\u0bc7\\u0bb3\\u0bcd\\u0bb5\\u0bbf\\u0b95\\u0bb3\\u0bc8\\u0b95\\u0bcd \\u0b95\\u0bbe\\u0ba3\\u0bcd\\u0b95","examseries":"Examseries","edit_coupon":"\\u0b95\\u0bc2\\u0baa\\u0bcd\\u0baa\\u0ba9\\u0bcd \\u0ba4\\u0bbf\\u0bb0\\u0bc1\\u0ba4\\u0bcd\\u0ba4\\u0bc1","coupon_code":"\\u0b95\\u0bc2\\u0baa\\u0bcd\\u0baa\\u0ba9\\u0bcd \\u0b95\\u0bc1\\u0bb1\\u0bbf\\u0baf\\u0bc0\\u0b9f\\u0bc1","value":"\\u0bae\\u0ba4\\u0bbf\\u0baa\\u0bcd\\u0baa\\u0bc1","percent":"\\u0b9a\\u0ba4\\u0bb5\\u0bc0\\u0ba4\\u0bae\\u0bcd","discount_type":"\\u0ba4\\u0bb3\\u0bcd\\u0bb3\\u0bc1\\u0baa\\u0b9f\\u0bbf \\u0bb5\\u0b95\\u0bc8","discount_value":"\\u0ba4\\u0bb3\\u0bcd\\u0bb3\\u0bc1\\u0baa\\u0b9f\\u0bbf \\u0bae\\u0ba4\\u0bbf\\u0baa\\u0bcd\\u0baa\\u0bc1","enter_value":"\\u0bae\\u0ba4\\u0bbf\\u0baa\\u0bcd\\u0baa\\u0bc8 \\u0b89\\u0bb3\\u0bcd\\u0bb3\\u0bbf\\u0b9f\\u0bb5\\u0bc1\\u0bae\\u0bcd","discount_maximum_amount":"\\u0ba4\\u0bb3\\u0bcd\\u0bb3\\u0bc1\\u0baa\\u0b9f\\u0bbf \\u0b85\\u0ba4\\u0bbf\\u0b95\\u0baa\\u0b9f\\u0bcd\\u0b9a \\u0b85\\u0bb3\\u0bb5\\u0bc1","enter_maximum_amount":"\\u0b85\\u0ba4\\u0bbf\\u0b95\\u0baa\\u0b9f\\u0bcd\\u0b9a \\u0b85\\u0bb3\\u0bb5\\u0bc1 \\u0b9a\\u0bc7\\u0bb0\\u0bcd\\u0b95\\u0bcd\\u0b95\\u0bb5\\u0bc1\\u0bae\\u0bcd","valid_from":"\\u0b9a\\u0bc6\\u0bb2\\u0bcd\\u0bb2\\u0bc1\\u0baa\\u0b9f\\u0bbf\\u0baf\\u0bbe\\u0b95\\u0bc1\\u0bae\\u0bcd","valid_to":"\\u0b9a\\u0bc6\\u0bb2\\u0bcd\\u0bb2\\u0bc1\\u0baa\\u0b9f\\u0bbf\\u0baf\\u0bbe\\u0b95\\u0bc1\\u0bae\\u0bcd","usage_limit":"\\u0baa\\u0baf\\u0ba9\\u0bcd\\u0baa\\u0bbe\\u0b9f\\u0bc1 \\u0b95\\u0bc1\\u0bb1\\u0bc8\\u0b95\\u0bcd\\u0b95","enter_usage_limit_per_user":"\\u0baa\\u0baf\\u0ba9\\u0bb0\\u0bcd \\u0b92\\u0ba9\\u0bcd\\u0bb1\\u0bc1\\u0b95\\u0bcd\\u0b95\\u0bc1 \\u0baa\\u0baf\\u0ba9\\u0bcd\\u0baa\\u0bbe\\u0b9f\\u0bc1 \\u0b95\\u0bc1\\u0bb1\\u0bc8\\u0b95\\u0bcd\\u0b95 \\u0b89\\u0bb3\\u0bcd\\u0bb3\\u0bbf\\u0b9f\\u0bb5\\u0bc1\\u0bae\\u0bcd","pending":"\\u0ba8\\u0bbf\\u0bb2\\u0bc1\\u0bb5\\u0bc8\\u0baf\\u0bbf\\u0bb2\\u0bcd","total":"\\u0bae\\u0bc6\\u0bbe\\u0ba4\\u0bcd\\u0ba4","overall_statistics":"\\u0b92\\u0b9f\\u0bcd\\u0b9f\\u0bc1\\u0bae\\u0bc6\\u0bbe\\u0ba4\\u0bcd\\u0ba4 \\u0baa\\u0bc1\\u0bb3\\u0bcd\\u0bb3\\u0bbf\\u0bb5\\u0bbf\\u0baa\\u0bb0\\u0bae\\u0bcd","payments_reports_in":"\\u0baa\\u0ba3\\u0bae\\u0bcd \\u0b85\\u0bb1\\u0bbf\\u0b95\\u0bcd\\u0b95\\u0bc8\\u0b95\\u0bb3\\u0bcd","payments":"\\u0b95\\u0bc6\\u0bbe\\u0b9f\\u0bc1\\u0baa\\u0bcd\\u0baa\\u0ba9\\u0bb5\\u0bc1","payment_statistics":"\\u0b95\\u0bc6\\u0bbe\\u0b9f\\u0bc1\\u0baa\\u0bcd\\u0baa\\u0ba9\\u0bb5\\u0bc1 \\u0baa\\u0bc1\\u0bb3\\u0bcd\\u0bb3\\u0bbf\\u0baf\\u0bbf\\u0baf\\u0bb2\\u0bcd","payment_monthly_statistics":"\\u0bae\\u0bbe\\u0ba4\\u0bbe\\u0ba8\\u0bcd\\u0ba4\\u0bbf\\u0bb0 \\u0baa\\u0bc1\\u0bb3\\u0bcd\\u0bb3\\u0bbf\\u0bb5\\u0bbf\\u0baa\\u0bb0\\u0bae\\u0bcd","feed_backs":"\\u0b8a\\u0b9f\\u0bcd\\u0b9f\\u0bae\\u0bcd \\u0bae\\u0bc1\\u0ba4\\u0bc1\\u0b95\\u0bc1\\u0b95\\u0bcd\\u0b95\\u0bc1","posted_on":"posted On","view":"\\u0b95\\u0bbe\\u0ba3\\u0bcd\\u0b95","feedback_details":"\\u0b95\\u0bb0\\u0bc1\\u0ba4\\u0bcd\\u0ba4\\u0bc1 \\u0bb5\\u0bbf\\u0baa\\u0bb0\\u0b99\\u0bcd\\u0b95\\u0bb3\\u0bcd","feedbacks":"\\u0baa\\u0bbf\\u0ba9\\u0bcd\\u0ba9\\u0bc2\\u0b9f\\u0bcd\\u0b9f\\u0b99\\u0bcd\\u0b95\\u0bb3\\u0bc8","back":"\\u0bae\\u0bc0\\u0ba3\\u0bcd\\u0b9f\\u0bc1\\u0bae\\u0bcd","module":"\\u0ba4\\u0bc6\\u0bbe\\u0b95\\u0bc1\\u0ba4\\u0bbf","key":"\\u0bae\\u0bc1\\u0b95\\u0bcd\\u0b95\\u0bbf\\u0baf","demanding_quizzes":"\\u0b95\\u0bc7\\u0bbe\\u0bb0\\u0bbf \\u0bb5\\u0bbf\\u0ba9\\u0bbe\\u0bb5\\u0bbf\\u0b9f\\u0bc8","demanding":"\\u0b95\\u0bc7\\u0bbe\\u0bb0\\u0bbf","quizzes_usage":"\\u0bb5\\u0bbf\\u0ba9\\u0bbe\\u0bb5\\u0bbf\\u0b9f\\u0bc8 \\u0baa\\u0baf\\u0ba9\\u0bcd\\u0baa\\u0bbe\\u0b9f\\u0bc1","paid_quizzes_usage":"\\u0baa\\u0ba3\\u0bae\\u0bcd \\u0bb5\\u0bbf\\u0ba9\\u0bbe\\u0bb5\\u0bbf\\u0b9f\\u0bc8 \\u0baa\\u0baf\\u0ba9\\u0bcd\\u0baa\\u0bbe\\u0b9f\\u0bc1","your_payment_was cancelled":"\\u0b89\\u0b99\\u0bcd\\u0b95\\u0bb3\\u0bcd \\u0baa\\u0ba3\\u0bae\\u0bcd \\u0bb0\\u0ba4\\u0bcd\\u0ba4\\u0bc1 \\u0b9a\\u0bc6\\u0baf\\u0bcd\\u0baf\\u0baa\\u0bcd\\u0baa\\u0b9f\\u0bcd\\u0b9f\\u0ba4\\u0bc1","subscriptions_list":"\\u0b9a\\u0ba8\\u0bcd\\u0ba4\\u0bbe\\u0b95\\u0bcd\\u0b95\\u0bb3\\u0bcd \\u0baa\\u0b9f\\u0bcd\\u0b9f\\u0bbf\\u0baf\\u0bb2\\u0bcd","plan_type":"\\u0ba4\\u0bbf\\u0b9f\\u0bcd\\u0b9f\\u0bae\\u0bcd \\u0bb5\\u0b95\\u0bc8","paid_from":"\\u0b87\\u0bb0\\u0bc1\\u0ba8\\u0bcd\\u0ba4\\u0bc1 \\u0baa\\u0ba3\\u0bae\\u0bcd","datetime":"\\u0ba4\\u0bc7\\u0ba4\\u0bbf \\u0ba8\\u0bc7\\u0bb0\\u0bae\\u0bcd","my_bookmarks":"\\u0b8e\\u0ba9\\u0ba4\\u0bc1 \\u0baa\\u0bc1\\u0b95\\u0bcd\\u0bae\\u0bbe\\u0bb0\\u0bcd\\u0b95\\u0bcd\\u0b95\\u0bc1\\u0b95\\u0bb3\\u0bcd","analysis":"\\u0baa\\u0b95\\u0bc1\\u0baa\\u0bcd\\u0baa\\u0bbe\\u0baf\\u0bcd\\u0bb5\\u0bc1","by_subjcet":"Subjcet \\u0bae\\u0bc2\\u0bb2\\u0bae\\u0bcd","by_exam":"\\u0ba4\\u0bc7\\u0bb0\\u0bcd\\u0bb5\\u0bc1 \\u0bae\\u0bc2\\u0bb2\\u0bae\\u0bcd","history":"\\u0bb5\\u0bb0\\u0bb2\\u0bbe\\u0bb1\\u0bc1","subscriptions":"\\u0b9a\\u0ba8\\u0bcd\\u0ba4\\u0bbe\\u0b95\\u0bcd\\u0b95\\u0bb3\\u0bcd","add_setting":"\\u0b85\\u0bae\\u0bc8\\u0ba4\\u0bcd\\u0ba4\\u0bb2\\u0bcd \\u0b9a\\u0bc7\\u0bb0\\u0bcd","introduction":"\\u0b85\\u0bb1\\u0bbf\\u0bae\\u0bc1\\u0b95\\u0bae\\u0bcd","description_of_the_topic":"\\u0ba4\\u0bb2\\u0bc8\\u0baa\\u0bcd\\u0baa\\u0bbf\\u0ba9\\u0bcd \\u0bb5\\u0bbf\\u0bb3\\u0b95\\u0bcd\\u0b95\\u0bae\\u0bcd","old_password":"\\u0baa\\u0bb4\\u0bc8\\u0baf \\u0b95\\u0b9f\\u0bb5\\u0bc1\\u0b9a\\u0bcd\\u0b9a\\u0bc6\\u0bbe\\u0bb2\\u0bcd","the_password_is_too_short":"\\u0b95\\u0b9f\\u0bb5\\u0bc1\\u0b9a\\u0bcd\\u0b9a\\u0bc6\\u0bbe\\u0bb2\\u0bcd \\u0bae\\u0bbf\\u0b95\\u0bb5\\u0bc1\\u0bae\\u0bcd \\u0b9a\\u0bbf\\u0bb1\\u0bbf\\u0baf\\u0ba4\\u0bbe\\u0b95 \\u0b89\\u0bb3\\u0bcd\\u0bb3\\u0ba4\\u0bc1","new_password":"\\u0baa\\u0bc1\\u0ba4\\u0bbf\\u0baf \\u0b95\\u0b9f\\u0bb5\\u0bc1\\u0b9a\\u0bcd\\u0b9a\\u0bc6\\u0bbe\\u0bb2\\u0bcd","retype_password":"\\u0b95\\u0b9f\\u0bb5\\u0bc1\\u0b9a\\u0bcd\\u0b9a\\u0bc6\\u0bbe\\u0bb2\\u0bcd\\u0bb2\\u0bc8 \\u0bae\\u0bc0\\u0ba3\\u0bcd\\u0b9f\\u0bc1\\u0bae\\u0bcd \\u0ba4\\u0b9f\\u0bcd\\u0b9f\\u0b9a\\u0bcd\\u0b9a\\u0bc1 \\u0b9a\\u0bc6\\u0baf\\u0bcd\\u0b95","password_and_confirm_password_does_not_match":"\\u0b95\\u0b9f\\u0bb5\\u0bc1\\u0b9a\\u0bcd\\u0b9a\\u0bc6\\u0bbe\\u0bb2\\u0bcd \\u0b89\\u0bb1\\u0bc1\\u0ba4\\u0bbf \\u0b95\\u0b9f\\u0bb5\\u0bc1\\u0b9a\\u0bcd\\u0b9a\\u0bc6\\u0bbe\\u0bb2\\u0bcd \\u0baa\\u0bc6\\u0bbe\\u0bb0\\u0bc1\\u0ba8\\u0bcd\\u0ba4\\u0bb5\\u0bbf\\u0bb2\\u0bcd\\u0bb2\\u0bc8","correct":"\\u0b9a\\u0bb0\\u0bbf","wrong":"\\u0ba4\\u0bb5\\u0bb1\\u0bbe\\u0ba9","not_answered":"\\u0baa\\u0ba4\\u0bbf\\u0bb2\\u0bb3\\u0bbf\\u0b95\\u0bcd\\u0b95\\u0bb5\\u0bbf\\u0bb2\\u0bcd\\u0bb2\\u0bc8","overall_performance":"\\u0bae\\u0bc6\\u0bbe\\u0ba4\\u0bcd\\u0ba4\\u0ba4\\u0bcd\\u0ba4\\u0bbf\\u0bb2\\u0bcd \\u0b9a\\u0bc6\\u0baf\\u0bb2\\u0bcd\\u0ba4\\u0bbf\\u0bb1\\u0ba9\\u0bcd","performance":"\\u0b9a\\u0bc6\\u0baf\\u0bb2\\u0bcd\\u0ba4\\u0bbf\\u0bb1\\u0ba9\\u0bcd","best_performance_in_all_quizzes":"\\u0b85\\u0ba9\\u0bc8\\u0ba4\\u0bcd\\u0ba4\\u0bc1 \\u0bb5\\u0bbf\\u0ba9\\u0bbe\\u0bb5\\u0bbf\\u0b9f\\u0bc8 \\u0b9a\\u0bbf\\u0bb1\\u0ba8\\u0bcd\\u0ba4 \\u0ba8\\u0b9f\\u0bbf\\u0baa\\u0bcd\\u0baa\\u0bc1","view_analysis":"\\u0b95\\u0bbe\\u0ba3\\u0bcd\\u0b95 \\u0baa\\u0b95\\u0bc1\\u0baa\\u0bcd\\u0baa\\u0bbe\\u0baf\\u0bcd\\u0bb5\\u0bc1","edit_user":"\\u0baa\\u0baf\\u0ba9\\u0bb0\\u0bcd \\u0ba4\\u0bbf\\u0bb0\\u0bc1\\u0ba4\\u0bcd\\u0ba4\\u0bc1","username":"\\u0baa\\u0baf\\u0ba9\\u0bb0\\u0bcd\\u0baa\\u0bc6\\u0baf\\u0bb0\\u0bcd","select_role":"\\u0ba4\\u0bc7\\u0bb0\\u0bcd\\u0bb5\\u0bc1 \\u0baa\\u0b99\\u0bcd\\u0b95\\u0bc1","phone":"\\u0ba4\\u0bc6\\u0bbe\\u0bb2\\u0bc8\\u0baa\\u0bc7\\u0b9a\\u0bbf","please_enter_10-15_digit_mobile_number":"\\u0ba4\\u0baf\\u0bb5\\u0bc1 \\u0b9a\\u0bc6\\u0baf\\u0bcd\\u0ba4\\u0bc1 10-15 \\u0b87\\u0bb2\\u0b95\\u0bcd\\u0b95\\u0bae\\u0bcd \\u0bae\\u0bc6\\u0bbe\\u0baa\\u0bc8\\u0bb2\\u0bcd \\u0b8e\\u0ba3\\u0bcd\\u0ba3\\u0bc8 \\u0b89\\u0bb3\\u0bcd\\u0bb3\\u0bbf\\u0b9f\\u0bb5\\u0bc1\\u0bae\\u0bcd","please_enter_valid_phone_number":"\\u0ba4\\u0baf\\u0bb5\\u0bc1 \\u0b9a\\u0bc6\\u0baf\\u0bcd\\u0ba4\\u0bc1 \\u0b9a\\u0bb0\\u0bbf\\u0baf\\u0bbe\\u0ba9 \\u0ba4\\u0bc6\\u0bbe\\u0bb2\\u0bc8\\u0baa\\u0bc7\\u0b9a\\u0bbf \\u0b8e\\u0ba3\\u0bcd\\u0ba3\\u0bc8 \\u0b89\\u0bb3\\u0bcd\\u0bb3\\u0bbf\\u0b9f\\u0bb5\\u0bc1\\u0bae\\u0bcd","address":"\\u0bae\\u0bc1\\u0b95\\u0bb5\\u0bb0\\u0bbf","please_enter_your_address":"\\u0ba4\\u0baf\\u0bb5\\u0bc1 \\u0b9a\\u0bc6\\u0baf\\u0bcd\\u0ba4\\u0bc1 \\u0b89\\u0b99\\u0bcd\\u0b95\\u0bb3\\u0bcd \\u0bae\\u0bc1\\u0b95\\u0bb5\\u0bb0\\u0bbf\\u0baf\\u0bc8 \\u0b89\\u0bb3\\u0bcd\\u0bb3\\u0bbf\\u0b9f\\u0bb5\\u0bc1\\u0bae\\u0bcd","give_feedback":"\\u0b95\\u0bb0\\u0bc1\\u0ba4\\u0bcd\\u0ba4\\u0bc1 \\u0ba4\\u0bc6\\u0bb0\\u0bbf\\u0bb5\\u0bbf","feedback_form":"\\u0b95\\u0bb0\\u0bc1\\u0ba4\\u0bcd\\u0ba4\\u0bc1 \\u0baa\\u0b9f\\u0bbf\\u0bb5\\u0bae\\u0bcd","send":"\\u0b85\\u0ba9\\u0bc1\\u0baa\\u0bcd\\u0baa\\u0bc1","account_settings":"\\u0b95\\u0ba3\\u0b95\\u0bcd\\u0b95\\u0bc1 \\u0b85\\u0bae\\u0bc8\\u0baa\\u0bcd\\u0baa\\u0bc1\\u0b95\\u0bb3\\u0bcd","quiz_and_exam_series":"\\u0bb5\\u0bbf\\u0ba9\\u0bbe\\u0b9f\\u0bbf \\u0bb5\\u0bbf\\u0ba9\\u0bbe \\u0bae\\u0bb1\\u0bcd\\u0bb1\\u0bc1\\u0bae\\u0bcd \\u0baa\\u0bb0\\u0bc0\\u0b9f\\u0bcd\\u0b9a\\u0bc8 \\u0ba4\\u0bc6\\u0bbe\\u0b9f\\u0bb0\\u0bcd","lms_categories":"LMS \\u0bb5\\u0b95\\u0bc8\\u0b95\\u0bb3\\u0bcd","time_spent_on_correct_answers":"\\u0ba8\\u0bc7\\u0bb0\\u0bae\\u0bcd \\u0b9a\\u0bb0\\u0bbf\\u0baf\\u0bbe\\u0ba9 \\u0baa\\u0ba4\\u0bbf\\u0bb2\\u0bcd\\u0b95\\u0bb3\\u0bc8 \\u0b9a\\u0bc6\\u0bb2\\u0bb5\\u0bc1","time_spent_on_wrong_answers":"\\u0ba8\\u0bc7\\u0bb0\\u0bae\\u0bcd \\u0ba4\\u0bb5\\u0bb1\\u0bbe\\u0ba9 \\u0baa\\u0ba4\\u0bbf\\u0bb2\\u0bcd\\u0b95\\u0bb3\\u0bc8 \\u0b9a\\u0bc6\\u0bb2\\u0bb5\\u0bc1","overall_marks_analysis":"\\u0b92\\u0b9f\\u0bcd\\u0b9f\\u0bc1\\u0bae\\u0bc6\\u0bbe\\u0ba4\\u0bcd\\u0ba4 \\u0bae\\u0bbe\\u0bb0\\u0bcd\\u0b95\\u0bcd\\u0bb8\\u0bcd \\u0baa\\u0b95\\u0bc1\\u0baa\\u0bcd\\u0baa\\u0bbe\\u0baf\\u0bcd\\u0bb5\\u0bc1","overall_subject_wise_analysis":"\\u0b92\\u0b9f\\u0bcd\\u0b9f\\u0bc1\\u0bae\\u0bc6\\u0bbe\\u0ba4\\u0bcd\\u0ba4 \\u0baa\\u0bc6\\u0bbe\\u0bb0\\u0bc1\\u0bb3\\u0bcd \\u0bb5\\u0bbe\\u0bb0\\u0bbf\\u0baf\\u0bbe\\u0b95 \\u0baa\\u0b95\\u0bc1\\u0baa\\u0bcd\\u0baa\\u0bbe\\u0baf\\u0bcd\\u0bb5\\u0bc1","of":"\\u0b8e\\u0ba9\\u0bcd\\u0bb1","spent_on_correct":"\\u0b9a\\u0bb0\\u0bbf\\u0baf\\u0bbe\\u0ba9 \\u0b9a\\u0bc6\\u0bb2\\u0bb5\\u0bc1","spent_on_wrong":"\\u0ba4\\u0bb5\\u0bb1\\u0bbe\\u0ba9 \\u0b9a\\u0bc6\\u0bb2\\u0bb5\\u0bc1","total_time":"\\u0bae\\u0bc6\\u0bbe\\u0ba4\\u0bcd\\u0ba4 \\u0ba8\\u0bc7\\u0bb0\\u0bae\\u0bcd","spent_time":"\\u0b95\\u0bb4\\u0bbf\\u0ba4\\u0bcd\\u0ba4 \\u0ba8\\u0bc7\\u0bb0\\u0bae\\u0bcd","all_exams":"\\u0b85\\u0ba9\\u0bc8\\u0ba4\\u0bcd\\u0ba4\\u0bc1 \\u0ba4\\u0bc7\\u0bb0\\u0bcd\\u0bb5\\u0bc1\\u0b95\\u0bb3\\u0bcd","dueration":"Dueration","take_exam":"\\u0baa\\u0bb0\\u0bc0\\u0b9f\\u0bcd\\u0b9a\\u0bc8 \\u0b8e\\u0b9f\\u0bc1\\u0b95\\u0bcd\\u0b95","mins":"mins","please_read_the_instructions_carefully":"\\u0b95\\u0bb5\\u0ba9\\u0bae\\u0bbe\\u0b95 \\u0b85\\u0bb1\\u0bbf\\u0bb5\\u0bc1\\u0bb0\\u0bc8\\u0b95\\u0bb3\\u0bc8 \\u0baa\\u0b9f\\u0bbf\\u0ba4\\u0bcd\\u0ba4\\u0bc1 \\u0b95\\u0bc6\\u0bbe\\u0bb3\\u0bcd\\u0bb3\\u0bb5\\u0bc1\\u0bae\\u0bcd","general_instructions":"\\u0baa\\u0bc6\\u0bbe\\u0ba4\\u0bc1 \\u0bb5\\u0bb4\\u0bbf\\u0bae\\u0bc1\\u0bb1\\u0bc8\\u0b95\\u0bb3\\u0bcd","buy_now":"\\u0b87\\u0baa\\u0bcd\\u0baa\\u0bc7\\u0bbe\\u0ba4\\u0bc1 \\u0bb5\\u0bbe\\u0b99\\u0bcd\\u0b95","checkout":"\\u0bb5\\u0bc6\\u0bb3\\u0bbf\\u0baf\\u0bc7\\u0bb1\\u0bc1\\u0ba4\\u0bb2\\u0bcd","valid_for":"\\u0b9a\\u0bc6\\u0bb2\\u0bcd\\u0bb2\\u0bc1\\u0baa\\u0b9f\\u0bbf\\u0baf\\u0bbe\\u0b95\\u0bc1\\u0bae\\u0bcd","days":"\\u0ba8\\u0bbe\\u0b9f\\u0bcd\\u0b95\\u0bb3\\u0bbf\\u0bb2\\u0bcd","enter_coupon_code":"\\u0b95\\u0bc2\\u0baa\\u0bcd\\u0baa\\u0ba9\\u0bcd \\u0b95\\u0bc1\\u0bb1\\u0bbf\\u0baf\\u0bc0\\u0b9f\\u0bc1 \\u0ba8\\u0bc1\\u0bb4\\u0bc8\\u0baf","apply":"\\u0bb5\\u0bbf\\u0ba3\\u0bcd\\u0ba3\\u0baa\\u0bcd\\u0baa\\u0bbf\\u0b95\\u0bcd\\u0b95","payu":"Payu","paypal":"\\u0baa\\u0bc7\\u0baa\\u0bbe\\u0bb2\\u0bcd","click_here_to_update_payment_details":"\\u0b95\\u0bc6\\u0bbe\\u0b9f\\u0bc1\\u0baa\\u0bcd\\u0baa\\u0ba9\\u0bb5\\u0bc1 \\u0bb5\\u0bbf\\u0bb5\\u0bb0\\u0b99\\u0bcd\\u0b95\\u0bb3\\u0bcd \\u0baa\\u0bc1\\u0ba4\\u0bc1\\u0baa\\u0bcd\\u0baa\\u0bbf\\u0b95\\u0bcd\\u0b95 \\u0b87\\u0b99\\u0bcd\\u0b95\\u0bc1 \\u0b95\\u0bbf\\u0bb3\\u0bbf\\u0b95\\u0bcd","offline_payment":"\\u0ba8\\u0ba9\\u0bcd\\u0bb1\\u0bbf \\u0b9a\\u0bc6\\u0bb2\\u0bc1\\u0ba4\\u0bcd\\u0ba4\\u0bc1\\u0ba4\\u0bb2\\u0bcd","details":"\\u0bb5\\u0bbf\\u0bb5\\u0bb0\\u0b99\\u0bcd\\u0b95\\u0bb3\\u0bcd","billing_address":"\\u0baa\\u0bbf\\u0bb2\\u0bcd\\u0bb2\\u0bbf\\u0b99\\u0bcd \\u0bae\\u0bc1\\u0b95\\u0bb5\\u0bb0\\u0bbf","limit_reached":"\\u0bb5\\u0bb0\\u0bc8\\u0baf\\u0bb1\\u0bc8\\u0baf\\u0bc8 \\u0b8e\\u0b9f\\u0bcd\\u0b9f\\u0bbf\\u0baf\\u0bc1\\u0bb3\\u0bcd\\u0bb3\\u0ba4\\u0bc1","hey_you_are_eligible_for_discount":"\\u0bb9\\u0bc7 \\u0baf\\u0bc2 \\u0ba4\\u0bb3\\u0bcd\\u0bb3\\u0bc1\\u0baa\\u0b9f\\u0bbf \\u0ba4\\u0b95\\u0bc1\\u0ba4\\u0bbf\\u0baf\\u0bc1\\u0b9f\\u0bc8\\u0baf\\u0bb5\\u0bb0\\u0bcd\\u0b95\\u0bb3\\u0bcd \\u0b86\\u0bb5\\u0bb0\\u0bcd","your_subscription_was_successfull":"\\u0b89\\u0b99\\u0bcd\\u0b95\\u0bb3\\u0bcd \\u0b9a\\u0ba8\\u0bcd\\u0ba4\\u0bbe\\u0bb5\\u0bc8 \\u0bb5\\u0bc6\\u0bb1\\u0bcd\\u0bb1\\u0bbf\\u0b95\\u0bb0\\u0bae\\u0bbe\\u0b95","please_accept_terms_and_conditions":"\\u0bb5\\u0bbf\\u0ba4\\u0bbf\\u0bae\\u0bc1\\u0bb1\\u0bc8\\u0b95\\u0bb3\\u0bcd \\u0bae\\u0bb1\\u0bcd\\u0bb1\\u0bc1\\u0bae\\u0bcd \\u0ba8\\u0bbf\\u0baa\\u0ba8\\u0bcd\\u0ba4\\u0ba9\\u0bc8\\u0b95\\u0bb3\\u0bcd \\u0ba4\\u0baf\\u0bb5\\u0bc1 \\u0b9a\\u0bc6\\u0baf\\u0bcd\\u0ba4\\u0bc1 \\u0b8f\\u0bb1\\u0bcd\\u0bb1\\u0bc1\\u0b95\\u0bcd\\u0b95\\u0bc6\\u0bbe\\u0bb3\\u0bcd\\u0bb3\\u0bc1\\u0b99\\u0bcd\\u0b95\\u0bb3\\u0bcd","start_exam":"\\u0ba4\\u0bc7\\u0bb0\\u0bcd\\u0bb5\\u0bc1 \\u0ba4\\u0bc6\\u0bbe\\u0b9f\\u0b99\\u0bcd\\u0b95","previous":"\\u0bae\\u0bc1\\u0ba8\\u0bcd\\u0ba4\\u0bc8\\u0baf","next":"\\u0b85\\u0b9f\\u0bc1\\u0ba4\\u0bcd\\u0ba4","clear_answer":"\\u0ba4\\u0bc6\\u0bb3\\u0bbf\\u0bb5\\u0bbe\\u0ba9 \\u0baa\\u0ba4\\u0bbf\\u0bb2\\u0bcd","bookmarks":"\\u0baa\\u0bc1\\u0b95\\u0bcd\\u0bae\\u0bbe\\u0bb0\\u0bcd\\u0b95\\u0bcd\\u0bb8\\u0bcd","exam_duration":"\\u0ba4\\u0bc7\\u0bb0\\u0bcd\\u0bb5\\u0bc1 \\u0b95\\u0bbe\\u0bb2\\u0bae\\u0bcd","hints":"\\u0b95\\u0bc1\\u0bb1\\u0bbf\\u0baa\\u0bcd\\u0baa\\u0bc1\\u0b95\\u0bb3\\u0bcd","bookmark_this_question":"\\u0b87\\u0ba8\\u0bcd\\u0ba4\\u0b95\\u0bcd \\u0b95\\u0bc7\\u0bb3\\u0bcd\\u0bb5\\u0bbf\\u0baf\\u0bc8\\u0b95\\u0bcd \\u0baa\\u0bc1\\u0b95\\u0bcd\\u0bae\\u0bbe\\u0bb0\\u0bcd\\u0b95\\u0bcd","unbookmark_this_question":"Unbookmark \\u0b87\\u0ba8\\u0bcd\\u0ba4\\u0b95\\u0bcd \\u0b95\\u0bc7\\u0bb3\\u0bcd\\u0bb5\\u0bbf\\u0baf\\u0bc8\\u0b95\\u0bcd","mark_for_review":"\\u0bae\\u0bbe\\u0bb0\\u0bcd\\u0b95\\u0bcd, \\u0bb5\\u0bbf\\u0bae\\u0bb0\\u0bcd\\u0b9a\\u0ba9\\u0bae\\u0bcd","finish":"\\u0baa\\u0bbf\\u0ba9\\u0bbf\\u0bb7\\u0bcd","summary":"\\u0b9a\\u0bc1\\u0bb0\\u0bc1\\u0b95\\u0bcd\\u0b95\\u0bae\\u0bcd","answered":"\\u0baa\\u0ba4\\u0bbf\\u0bb2\\u0bcd","marked":"\\u0b95\\u0bc1\\u0bb1\\u0bbf\\u0b95\\u0bcd\\u0b95\\u0baa\\u0bcd\\u0baa\\u0b9f\\u0bcd\\u0b9f\\u0ba4\\u0bc1","not_visited":"\\u0bb5\\u0bbf\\u0b9c\\u0baf\\u0bae\\u0bcd","consumed_time":"\\u0b89\\u0b9f\\u0bcd\\u0b95\\u0bc6\\u0bbe\\u0bb3\\u0bcd\\u0bb3\\u0baa\\u0bcd\\u0baa\\u0b9f\\u0bc1\\u0b95\\u0bbf\\u0bb1\\u0ba4\\u0bc1 \\u0ba8\\u0bc7\\u0bb0\\u0bae\\u0bcd","result_for":"\\u0bae\\u0bc1\\u0b9f\\u0bbf\\u0bb5\\u0bc1","score":"\\u0bb8\\u0bcd\\u0b95\\u0bc7\\u0bbe\\u0bb0\\u0bcd","percentage":"\\u0b9a\\u0ba4\\u0bb5\\u0bbf\\u0ba4\\u0bae\\u0bcd","grade":"\\u0ba4\\u0bb0\\u0bae\\u0bcd","view_key":"\\u0b95\\u0bbe\\u0ba3\\u0bcd\\u0b95 \\u0bae\\u0bc1\\u0b95\\u0bcd\\u0b95\\u0bbf\\u0baf","toppers_in_this_exam":"\\u0b87\\u0ba8\\u0bcd\\u0ba4 \\u0ba4\\u0bc7\\u0bb0\\u0bcd\\u0bb5\\u0bbf\\u0bb2\\u0bcd \\u0bae\\u0bc1\\u0ba4\\u0bb2\\u0bbf\\u0b9f\\u0ba4\\u0bcd\\u0ba4\\u0bbf\\u0bb2\\u0bcd","click on toper to compare your score":"\\u0b89\\u0b99\\u0bcd\\u0b95\\u0bb3\\u0bcd \\u0bb8\\u0bcd\\u0b95\\u0bc7\\u0bbe\\u0bb0\\u0bcd \\u0b92\\u0baa\\u0bcd\\u0baa\\u0bbf\\u0b9f\\u0bcd\\u0b9f\\u0bc1 Toper \\u0b95\\u0bbf\\u0bb3\\u0bbf\\u0b95\\u0bcd \\u0b9a\\u0bc6\\u0baf\\u0bcd\\u0baf\\u0bb5\\u0bc1\\u0bae\\u0bcd","answers":"\\u0baa\\u0ba4\\u0bbf\\u0bb2\\u0bcd\\u0b95\\u0bb3\\u0bcd","result":"\\u0bb5\\u0bbf\\u0bb3\\u0bc8\\u0bb5\\u0bbe\\u0b95","time_limit":"\\u0ba8\\u0bc7\\u0bb0 \\u0bb5\\u0bb0\\u0bae\\u0bcd\\u0baa\\u0bbf\\u0bb1\\u0bcd\\u0b95\\u0bc1","time_taken":"\\u0b8e\\u0b9f\\u0bc1\\u0ba4\\u0bcd\\u0ba4\\u0bc1\\u0b95\\u0bcd\\u0b95\\u0bc6\\u0bbe\\u0ba3\\u0bcd\\u0b9f \\u0ba8\\u0bc7\\u0bb0\\u0bae\\u0bcd","explanation":"\\u0bb5\\u0bbf\\u0bb3\\u0b95\\u0bcd\\u0b95\\u0bae\\u0bcd","exam_analysis":"\\u0ba4\\u0bc7\\u0bb0\\u0bcd\\u0bb5\\u0bc1 \\u0baa\\u0b95\\u0bc1\\u0baa\\u0bcd\\u0baa\\u0bbe\\u0baf\\u0bcd\\u0bb5\\u0bc1","attempts":"\\u0bae\\u0bc1\\u0baf\\u0bb1\\u0bcd\\u0b9a\\u0bbf\\u0b95\\u0bb3\\u0bcd","analysis_by_exam":"\\u0ba4\\u0bc7\\u0bb0\\u0bcd\\u0bb5\\u0bc1 \\u0bae\\u0bc2\\u0bb2\\u0bae\\u0bcd \\u0baa\\u0b95\\u0bc1\\u0baa\\u0bcd\\u0baa\\u0bbe\\u0baf\\u0bcd\\u0bb5\\u0bc1","children":"\\u0b95\\u0bc1\\u0bb4\\u0ba8\\u0bcd\\u0ba4\\u0bc8\\u0b95\\u0bb3\\u0bcd","no_categories_available":"\\u0b95\\u0bbf\\u0b9f\\u0bc8\\u0b95\\u0bcd\\u0b95\\u0bc1\\u0bae\\u0bcd \\u0b87\\u0bb2\\u0bcd\\u0bb2\\u0bc8 \\u0bb5\\u0b95\\u0bc8\\u0b95\\u0bb3\\u0bcd","click_here_to_change_your_preferences":"\\u0b89\\u0b99\\u0bcd\\u0b95\\u0bb3\\u0bcd \\u0bb5\\u0bbf\\u0bb0\\u0bc1\\u0baa\\u0bcd\\u0baa\\u0b99\\u0bcd\\u0b95\\u0bb3\\u0bcd \\u0bae\\u0bbe\\u0bb1\\u0bcd\\u0bb1 \\u0b87\\u0b99\\u0bcd\\u0b95\\u0bc7 \\u0b95\\u0bbf\\u0bb3\\u0bbf\\u0b95\\u0bcd \\u0b9a\\u0bc6\\u0baf\\u0bcd\\u0baf\\u0bb5\\u0bc1\\u0bae\\u0bcd","record_added_successfully":"\\u0baa\\u0ba4\\u0bbf\\u0bb5\\u0bc1 \\u0b9a\\u0bc7\\u0bb0\\u0bcd\\u0b95\\u0bcd\\u0b95\\u0baa\\u0bcd\\u0baa\\u0b9f\\u0bcd\\u0b9f\\u0ba4\\u0bc1 \\u0bb5\\u0bc6\\u0bb1\\u0bcd\\u0bb1\\u0bbf\\u0b95\\u0bb0\\u0bae\\u0bbe\\u0b95","lms_series":"LMS \\u0ba4\\u0bc6\\u0bbe\\u0b9f\\u0bb0\\u0bcd","no_series_available":"\\u0b95\\u0bbf\\u0b9f\\u0bc8\\u0b95\\u0bcd\\u0b95\\u0bc1\\u0bae\\u0bcd \\u0b8e\\u0ba8\\u0bcd\\u0ba4 \\u0ba4\\u0bc6\\u0bbe\\u0b9f\\u0bb0\\u0bcd","edit_quiz":"\\u0bb5\\u0bbf\\u0ba9\\u0bbe\\u0b9f\\u0bbf \\u0bb5\\u0bbf\\u0ba9\\u0bbe \\u0ba4\\u0bbf\\u0bb0\\u0bc1\\u0ba4\\u0bcd\\u0ba4\\u0bc1"}', '2016-08-23 00:09:43', '2016-10-19 19:26:39'),
(7, 'Urdu', 'urdu', 'ur', 1, 0, '{"success":"\\u06a9\\u0627\\u0645\\u06cc\\u0627\\u0628\\u06cc","record_updated_successfully":"\\u0631\\u06cc\\u06a9\\u0627\\u0631\\u0688 \\u06a9\\u0627\\u0645\\u06cc\\u0627\\u0628\\u06cc \\u0633\\u06d2 \\u0627\\u067e \\u0688\\u06cc\\u0679","languages":"\\u0632\\u0628\\u0627\\u0646\\u06cc\\u06ba","create":"\\u0628\\u0646\\u0627\\u0646\\u0627","language":"\\u0632\\u0628\\u0627\\u0646","code":"\\u0636\\u0627\\u0628\\u0637\\u06d2","is_rtl":"RTL \\u06c1\\u06d2","default_language":"\\u0688\\u06cc\\u0641\\u0627\\u0644\\u0679 \\u0644\\u06cc\\u0646\\u06af\\u0648\\u0626\\u062c","action":"\\u0639\\u0645\\u0644","deleted":"\\u062d\\u0630\\u0641 \\u0634\\u062f\\u06c1","sorry":"\\u0645\\u0639\\u0630\\u0631\\u062a","cannot_delete_this_record_as":"\\u062d\\u0630\\u0641 \\u0646\\u06c1\\u06cc\\u06ba \\u06a9\\u0631 \\u0633\\u06a9\\u062a\\u06d2 \\u0627\\u0633 \\u0631\\u06cc\\u06a9\\u0627\\u0631\\u0688 \\u06a9\\u06d2 \\u0637\\u0648\\u0631 \\u067e\\u0631","site_title":"\\u0648\\u06cc\\u0628 \\u0633\\u0627\\u0626\\u0679 \\u06a9\\u0627 \\u0639\\u0646\\u0648\\u0627\\u0646","latest_users":"\\u062a\\u0627\\u0632\\u06c1 \\u062a\\u0631\\u06cc\\u0646 \\u0635\\u0627\\u0631\\u0641\\u06cc\\u0646","was_joined_as":"\\u062c\\u06cc\\u0633\\u0627 \\u06a9\\u06c1 \\u0634\\u0627\\u0645\\u0644 \\u06a9\\u06cc\\u0627 \\u06af\\u06cc\\u0627 \\u062a\\u06be\\u0627","see_more":"\\u062f\\u06cc\\u06a9\\u06be\\u06cc\\u06ba \\u0645\\u0632\\u06cc\\u062f","my_profile":"\\u0645\\u06cc\\u0631\\u06cc \\u067e\\u0631\\u0648\\u0641\\u0627\\u0626\\u0644","change_password":"\\u067e\\u0627\\u0633 \\u0648\\u0631\\u0688 \\u062a\\u0628\\u062f\\u06cc\\u0644 \\u06a9\\u0631\\u06cc\\u06ba","logout":"\\u0644\\u0627\\u06af \\u0622\\u0648\\u0679","dashboard":"\\u0688\\u06cc\\u0634 \\u0628\\u0648\\u0631\\u0688","users":"\\u0635\\u0627\\u0631\\u0641\\u06cc\\u0646","roles":"\\u06a9\\u0631\\u062f\\u0627\\u0631","fee_settings":"\\u0641\\u06cc\\u0633 \\u062a\\u0631\\u062a\\u06cc\\u0628\\u0627\\u062a","fee_categories":"\\u0641\\u06cc\\u0633 \\u062c\\u0627\\u062a","fee_category_allotment":"\\u0641\\u06cc\\u0633 \\u0632\\u0645\\u0631\\u06c1 \\u062a\\u06cc\\u0646 \\u06c1\\u0644\\u0627\\u06a9","fee_particulars":"\\u0641\\u06cc\\u0633 \\u062a\\u0641\\u0635\\u06cc\\u0644\\u0627\\u062a","fee_schedules":"\\u0641\\u06cc\\u0633 \\u0634\\u06cc\\u0688\\u0648\\u0644","fines":"\\u062c\\u0631\\u0645\\u0627\\u0646\\u06c1","discounts":"\\u0688\\u0633\\u06a9\\u0627\\u0624\\u0646\\u0679\\u0633","master_settings":"\\u0645\\u0627\\u0633\\u0679\\u0631 \\u062a\\u0631\\u062a\\u06cc\\u0628\\u0627\\u062a","religions_master":"\\u0645\\u0630\\u0627\\u06c1\\u0628 \\u0645\\u0627\\u0633\\u0679\\u0631","academics_master":"\\u0645\\u0627\\u06c1\\u0631\\u06cc\\u0646 \\u062a\\u0639\\u0644\\u06cc\\u0645 \\u0645\\u0627\\u0633\\u0679\\u0631","courses_master":"\\u06a9\\u0648\\u0631\\u0633\\u0632 \\u0645\\u0627\\u0633\\u0679\\u0631","subjects_master":"\\u0645\\u0636\\u0627\\u0645\\u06cc\\u0646 \\u0645\\u06cc\\u06ba \\u0645\\u0627\\u0633\\u0679\\u0631","subject_topics":"\\u0645\\u0648\\u0636\\u0648\\u0639 \\u06a9\\u06d2 \\u0645\\u0648\\u0636\\u0648\\u0639\\u0627\\u062a","course_subjects":"\\u06a9\\u0648\\u0631\\u0633 \\u0645\\u0636\\u0627\\u0645\\u06cc\\u0646","email_templates":"\\u0627\\u06cc \\u0645\\u06cc\\u0644 \\u0633\\u0627\\u0646\\u0686\\u06d2","exams":"\\u0627\\u0645\\u062a\\u062d\\u0627\\u0646\\u0627\\u062a","categories":"\\u0627\\u0642\\u0633\\u0627\\u0645","question_bank":"\\u0633\\u0648\\u0627\\u0644 \\u0628\\u06cc\\u0646\\u06a9","quiz":"\\u06a9\\u0648\\u0626\\u0632","lms":"LMS","content":"\\u0645\\u0648\\u0627\\u062f","study_materials":"\\u0645\\u0637\\u0627\\u0644\\u0639\\u06c1 \\u0645\\u0648\\u0627\\u062f","library":"\\u0644\\u0627\\u0626\\u0628\\u0631\\u06cc\\u0631\\u06cc","asset_types":"\\u0627\\u062b\\u0627\\u062b\\u06c1 \\u06a9\\u06cc \\u0627\\u0642\\u0633\\u0627 \\u0645","master_data":"\\u0645\\u0627\\u0633\\u0679\\u0631 \\u0688\\u06cc\\u0679\\u0627","publishers":"\\u0646\\u0627\\u0634\\u0631\\u06cc\\u0646","authors":"\\u0645\\u0635\\u0646\\u0641\\u06cc\\u0646","students":"\\u0637\\u0644\\u0628\\u0627\\u0621","staff":"\\u0627\\u0633\\u0679\\u0627\\u0641","school_hub":"\\u0633\\u06a9\\u0648\\u0644 \\u062d\\u0628","attendance":"\\u062d\\u0627\\u0636\\u0631\\u06cc","edit":"\\u062a\\u0635\\u06cc\\u062d","delete":"\\u062d\\u0630\\u0641 \\u06a9\\u0631\\u06cc\\u06ba","enable":"\\u0641\\u0639\\u0627\\u0644","set_default":"\\u067e\\u06c1\\u0644\\u06d2 \\u0633\\u06d2 \\u0637\\u06d2 \\u0634\\u062f\\u06c1","disable":"\\u063a\\u06cc\\u0631 \\u0641\\u0639\\u0627\\u0644 \\u06a9\\u0631\\u06cc\\u06ba","user_statistics":"\\u06cc\\u0648\\u0632\\u0631 \\u06a9\\u06d2 \\u0627\\u0639\\u062f\\u0627\\u062f\\u0648\\u0634\\u0645\\u0627\\u0631","view_all":"\\u0633\\u0628 \\u062f\\u06cc\\u06a9\\u06be\\u06cc\\u06ba","quiz_categories":"\\u06a9\\u0648\\u0626\\u0632 \\u062c\\u0627\\u062a","quizzes":"QUIZZES","subjects":"\\u0645\\u0636\\u0627\\u0645\\u06cc\\u0646","topics":"\\u0645\\u0648\\u0636\\u0648\\u0639\\u0627\\u062a","questions":"\\u0633\\u0648\\u0627\\u0644\\u0627\\u062a"}', '2016-08-23 04:38:33', '2016-10-19 19:26:39');
INSERT INTO `languages` (`id`, `language`, `slug`, `code`, `is_rtl`, `is_default`, `phrases`, `created_at`, `updated_at`) VALUES
(9, 'English', 'english-1', 'en', 0, 1, '{"success":"Success","record_updated_successfully":"Record Updated Successfully","languages":"Languages","create":"Create","language":"Language","code":"Code","is_rtl":"Is Rtl","default_language":"Default Language","action":"Action","deleted":"Deleted","sorry":"Sorry","cannot_delete_this_record_as":"Cannot Delete This Record As","site_title":"Site Title","latest_users":"Latest Users","was_joined_as":"Was Joined As","see_more":"See More","my_profile":"My Profile","change_password":"Change Password","logout":"Logout","dashboard":"Dashboard","users":"Users","exams":"Exams","categories":"Categories","question_bank":"Question Bank","quiz":"Quiz","master_settings":"Master Settings","subjects_master":"Subjects Master","subject_topics":"Subject Topics","email_templates":"Email Templates","settings":"Settings","edit":"Edit","delete":"Delete","enable":"Enable","set_default":"Set Default","disable":"Disable","add_user":"Add User","name":"Name","email":"Email","image":"Image","role":"Role","edit_user":"Edit User","list":"List","update":"Update","this_field_is_required":"This Field Is Required","the_text_is_too_short":"The Text Is Too Short","the_text_is_too_long":"The Text Is Too Long","invalid_input":"Invalid Input","please_enter_valid_email":"Please Enter Valid Email","select_role":"Select Role","add_language":"Add Language","language_title":"Language Title","language_code":"Language Code","supported_language_codes":"Supported Language Codes","no":"No","yes":"Yes","edit_language":"Edit Language","add_users":"Add Users","quiz_categories":"Quiz Categories","category":"Category","description":"Description","create_category":"Create Category","category_name":"Category Name","please_upload_valid_image_type":"Please Upload Valid Image Type","edit_author":"Edit Author","question_subjects":"Question Subjects","add_subject":"Add Subject","subject":"Subject","view_questions":"View Questions","add":"Add","subjects":"Subjects","subject_title":"Subject Title","subject_code":"Subject Code","is_lab":"Is Lab","is_elective":"Is Elective","maximum_marks":"Maximum Marks","please_enter_valid_number":"Please Enter Valid Number","pass_marks":"Pass Marks","please_enter_valid_maximum_marks":"Please Enter Valid Maximum Marks","please_enter_valid_pass_marks":"Please Enter Valid Pass Marks","pass_marks_cannot_be_greater_than_maximum_marks":"Pass Marks Cannot Be Greater Than Maximum Marks","password":"Password","login":"Login","forgot_password":"Forgot Password","register":"Register","questions":"Questions","topic":"Topic","type":"Type","question":"Question","marks":"Marks","difficulty":"Difficulty","subjects_list":"Subjects List","max_marks":"Max Marks","topics_list":"Topics List","parent":"Parent","title":"Title","from_email":"From Email","from_name":"From Name","quizzes":"Quizzes","dueration":"Dueration","is_paid":"Is Paid","total_marks":"Total Marks","update_questions":"Update Questions","free":"Free","paid":"Paid","module":"Module","key":"Key","view":"View","add_setting":"Add Setting","edit_topic":"Edit Topic","topics":"Topics","select_parent":"Select Parent","topic_name":"Topic Name","edit_template":"Edit Template","welcome":"Welcome","content":"Content","email_content":"Email Content","create_template":"Create Template","select":"Select","add_topic":"Add Topic","user_statistics":"User Statistics","view_all":"View All","edit_subject":"Edit Subject","user_registration":"User Registration","password_confirmation":"Password Confirmation","password_and_confirm_password_does_not_match":"Password And Confirm Password Does Not Match","i_am_a_student":"I Am A Student","i_am_a_parent":"I Am A Parent","register_now":"Register Now","i_am_having_account":"I Am Having Account","children":"Children","edit_profile":"Edit Profile","buy_package":"Buy Package","all_exams":"All Exams","recent_activity":"Recent Activity","mins":"Mins","old_password":"Old Password","new_password":"New Password","retype_password":"Retype Password","exam_already_submitted":"Exam Already Submitted","history":"History","analysis":"Analysis","by_subjcet":"By Subjcet","by_exam":"By Exam","subscriptions":"Subscriptions","plans":"Plans","invoices":"Invoices","exam_analysis":"Exam Analysis","attempts":"Attempts","analysis_by_exam":"Analysis By Exam","of":"Of","exam_attempt":"Exam Attempt","marks_obtained":"Marks Obtained","exam_aborted":"Exam Aborted","take_exam":"Take Exam","exam_name":"Exam Name","explanation":"Explanation","previous":"Previous","mark_for_review":"Mark For Review","next":"Next","clear_answer":"Clear Answer","finish":"Finish","total_time":"Total Time","summary":"Summary","answered":"Answered","marked":"Marked","not_answered":"Not Answered","not_visited":"Not Visited","subscription_plans":"Subscription Plans","it_is_a":"It Is A","ooops__!":"Ooops..!","you_have_no_permission_to_access":"You Have No Permission To Access","correct":"Correct","wrong":"Wrong","overall_performance":"Overall Performance","performance":"Performance","best_performance_in_all_quizzes":"Best Performance In All Quizzes","view_analysis":"View Analysis","you_already_subscribed_to_use_this_system___":"You Already Subscribed To Use This System...","sno":"Sno","date":"Date","total":"Total","download":"Download","overall_subject_wise_analysis":"Overall Subject Wise Analysis","update_questions_for":"Update Questions For","page_not_found":"Page Not Found","ooops___!":"Ooops...!","inter_mathematicss__have_no_topics,_please_add_topics_to_upload_questions":"Inter Mathematicss  Have No Topics, Please Add Topics To Upload Questions","upload_question":"Upload Question","question_file":"Question File","difficulty_level":"Difficulty Level","hint":"Hint","question_type":"Question Type","total_options":"Total Options","answer_number":"Answer Number","total_correct_answers":"Total Correct Answers","total_blank_answers":"Total Blank Answers","left_title":"Left Title","right_title":"Right Title","left_option":"Left Option","total_questions":"Total Questions","create_quiz":"Create Quiz","quiz_title":"Quiz Title","enter_value_in_minutes":"Enter Value In Minutes","it_will_be_updated_by_adding_the_questions":"It Will Be Updated By Adding The Questions","pass_percentage":"Pass Percentage","edit_quiz":"Edit Quiz","currently_you_have_not_subscribed_to_any_plan":"Currently You Have Not Subscribed To Any Plan","subscription_was_successfull":"Subscription Was Successfull","congrats_you_account_is_successfully_subscribed_with":"Congrats You Account Is Successfully Subscribed With","plan_with_transaction_no":"Plan With Transaction No","record_added_successfully":"Record Added Successfully","user_details":"User Details","details_of":"Details Of","reports":"Reports","exam_history":"Exam History","view_details":"View Details","by_subject":"By Subject","exam_attempts_and_score":"Exam Attempts And Score","quiz_attempts":"Quiz Attempts","percentage":"Percentage","grade":"Grade","result":"Result","attempted_on":"Attempted On","edit_question":"Edit Question","password_updated_successfully":"Password Updated Successfully","result_for":"Result For","score":"Score","toppers_in_this_exam":"Toppers In This Exam","the_password_is_too_short":"The Password Is Too Short","explanation_file":"Explanation File","negative_mark":"Negative Mark","time_to_spend":"Time To Spend","in_seconds":"In Seconds","having_negative_mark":"Having Negative Mark","asset_belongs_to_subject":"Asset Belongs To Subject","is_having_url":"Is Having Url","question_file_is_url":"Question File Is Url","instructions":"Instructions","add_instructions":"Add Instructions","edit_instruction":"Edit Instruction","instructions_page":"Instructions Page","record_deleted_successfully":"Record Deleted Successfully","category_deleted_successfully":"Category Deleted Successfully","setting_key":"Setting Key","value":"Value","setting_value":"Setting Value","edit_settings":"Edit Settings","subject_wise_analysis":"Subject Wise Analysis","in":"In","exam":"Exam","my_bookmarks":"My Bookmarks","record_bookmarked":"Record Bookmarked","bookmark_already_available":"Bookmark Already Available","bookmark_removed":"Bookmark Removed","added_to_bookmarks":"Added To Bookmarks","unbookmark_this_question":"Unbookmark This Question","bookmark_this_question":"Bookmark This Question","remove_from_bookmarks":"Remove From Bookmarks","cost":"Cost","validity":"Validity","total_exams":"Total Exams","create_series":"Create Series","exam_series":"Exam Series","series_title":"Series Title","validity_in_days":"Validity In Days","it_will_be_updated_by_adding_the_exams":"It Will Be Updated By Adding The Exams","short_description":"Short Description","add_exam_series":"Add Exam Series","update_quizzes":"Update Quizzes","edit_series":"Edit Series","under_construction":"Under Construction","exam_categories":"Exam Categories","update_series_for":"Update Series For","saved_exams":"Saved Exams","no_data_available":"No Data Available","remove_all":"Remove All","add_series":"Add Series","no_settings_available":"No Settings Available","oops":"Oops","invalid_record":"Invalid Record","details":"Details","advantages_of_this_package":"Advantages Of This Package","it_includes":"It Includes","overview":"Overview","days":"Days","pay_now":"Pay Now","valid_for":"Valid For","apply":"Apply","enter_coupon_code":"Enter Coupon Code","paypal":"Paypal","payu":"Payu","your_subscription_was_successfull":"Your Subscription Was Successfull","subscriptions_list":"Subscriptions List","plan_type":"Plan Type","start_date":"Start Date","end_date":"End Date","paid_through":"Paid Through","coupon_applied":"Coupon Applied","your_payment_was_cancelled":"Your Payment Was Cancelled","status":"Status","paid_from":"Paid From","datetime":"Datetime","phone":"Phone","please_enter_valid_phone_number":"Please Enter Valid Phone Number","address":"Address","billing_address":"Billing Address","couponcodes":"Couponcodes","coupons":"Coupons","usage":"Usage","discount":"Discount","minimum_bill":"Minimum Bill","maximum_discount":"Maximum Discount","limit":"Limit","create_coupon":"Create Coupon","coupon_code":"Coupon Code","percent":"Percent","discount_type":"Discount Type","discount_value":"Discount Value","discount_maximum_amoumt":"Discount Maximum Amoumt","valid_from":"Valid From","valid_to":"Valid To","attendance_date":"Attendance Date","usage_limit":"Usage Limit","edit_coupon":"Edit Coupon","checkout":"Checkout","minimum_bill_not_reached__this_is_valid_for_minimum_purchase_of_$_100_00":"Minimum Bill Not Reached. This Is Valid For Minimum Purchase Of $ 100.00","invalid_coupon":"Invalid Coupon","hey_you_are_eligible_for_discount":"Hey You Are Eligible For Discount","limit_reached":"Limit Reached","hey":"Hey","you_already_purchased_this_item":"You Already Purchased This Item","hey_peter":"Hey Peter","buy_now":"Buy Now","start_series":"Start Series","lms_categories":"Lms Categories","lms_content":"Lms Content","author":"Author","masters":"Masters","select_category":"Select Category","content_type":"Content Type","is_series":"Is Series","series":"Series","resource_link":"Resource Link","coupons_usage":"Coupons Usage","lms":"Lms","study_materials":"Study Materials","edit_category":"Edit Category","contents":"Contents","create_content":"Create Content","add_content":"Add Content","enter_search_term":"Enter Search Term","search_term":"Search Term","select_subject":"Select Subject","file_path":"File Path","lms_file":"Lms File","updated_at":"Updated At","lms_contents":"Lms Contents","lms_series":"Lms Series","total_items":"Total Items","add_lms_series":"Add Lms Series","lms_category":"Lms Category","notifications":"Notifications","url":"Url","add_notification":"Add Notification","edit_notification":"Edit Notification","posted_on":"Posted On","file_type":"File Type","today":"Today","read_more":"Read More","items":"Items","view_more":"View More","learning_management_series":"Learning Management Series","premium":"Premium","import_excel":"Import Excel","import_users":"Import Users","upload":"Upload","answers":"Answers","attempted":"Attempted","time_spent_on_correct_answers":"Time Spent On Correct Answers","time_spent_on_wrong_answers":"Time Spent On Wrong Answers","overall_marks_analysis":"Overall Marks Analysis","spent_on_correct":"Spent On Correct","spent_on_wrong":"Spent On Wrong","spent_time":"Spent Time","congrats_you_are_the_new_top_10_scorer_of_this_exam":"Congrats You Are The New Top 10 Scorer Of This Exam","consumed_time":"Consumed Time","total_time_in_sec":"Total Time In Sec","view_key":"View Key","click_on_toper_to_compare_your_score":"Click On Toper To Compare Your Score","report":"Report","reason":"Reason","failed":"Failed","download_template":"Download Template","import_subjects":"Import Subjects","import":"Import","id":"Id","record_already_exists_with_this_title":"Record Already Exists With This Title","minimum_marks":"Minimum Marks","import_topics":"Import Topics","topic_id":"Topic Id","topic_(id)":"Topic (id)","invalid_subject_id":"Invalid Subject Id","unknown_error_occurred":"Unknown Error Occurred","subject_id":"Subject Id","operating_systems__have_no_topics,_please_add_topics_to_upload_questions":"Operating Systems  Have No Topics, Please Add Topics To Upload Questions","import_questions":"Import Questions","single_answers":"Single Answers","multi_answers":"Multi Answers","fill_blanks":"Fill Blanks","match_the_following":"Match The Following","paragraph":"Paragraph","this_question_is_not_type_of_":"This Question Is Not Type Of ","topic_not_available_with_subject":"Topic Not Available With Subject","insufficient_answers":"Insufficient Answers","invalid_difficulty_level":"Invalid Difficulty Level","total_answers":"Total Answers","single_answer":"Single Answer","multi_answer":"Multi Answer","fill_the_blanks":"Fill The Blanks","this_question_is_not_type_of__blank":"This Question Is Not Type Of  Blank","exam_toppers":"Exam Toppers","your_current_rank_id_is":"Your Current Rank Id Is","outof":" Outof","out_of":" Out Of","compare":"Compare","view_answers":"View Answers","exam_details":"Exam Details","total_users":"Total Users","correct_answers":"Correct Answers","wrong_answers":"Wrong Answers","time_taken_for_correct_answers":"Time Taken For Correct Answers","time_spent_on_not_answers":"Time Spent On Not Answers","your_result":"Your Result","your_best_rank_is":"Your Best Rank Is","feed_backs":"Feed Backs","give_feedback":"Give Feedback","enter_your_feedback_here":"Enter Your Feedback Here","send":"Send","feedback_form":"Feedback Form","feedback_submitted_successfully":"Feedback Submitted Successfully","feedback_details":"Feedback Details","feedbacks":"Feedbacks","back":"Back","deleted_successfully":"Deleted Successfully","feedback":"Feedback","create_message":"Create Message","messages":"Messages","inbox":"Inbox","compose":"Compose","send_message":"Send Message","this_question_is_not_type_of__radio":"This Question Is Not Type Of  Radio","upload_questions":"Upload Questions","time_spent_correct_answers":"Time Spent Correct Answers","time_spent_wrong_answers":"Time Spent Wrong Answers","this_question_is_not_type_of__blanks":"This Question Is Not Type Of  Blanks","this_question_is_not_type_of__checkbox":"This Question Is Not Type Of  Checkbox","data_structures__have_no_topics,_please_add_topics_to_upload_questions":"Data Structures  Have No Topics, Please Add Topics To Upload Questions","information_technology__have_no_topics,_please_add_topics_to_upload_questions":"Information Technology  Have No Topics, Please Add Topics To Upload Questions","username":"Username","please_subscribe_to_use_this_quiz":"Please Subscribe To Use This Quiz","option_value":"Option Value","option_text":"Option Text","make_default":"Make Default","currency":"Currency","account_type":"Account Type","site_address":"Site Address","site_city":"Site City","site_logo":"Site Logo","site_favicon":"Site Favicon","site_state":"Site State","site_country":"Site Country","site_zipcode":"Site Zipcode","site_phone":"Site Phone","meta_description":"Meta Description","meta_keywords":"Meta Keywords","payment_gateway_payu":"Payment Gateway Payu","payment_gateway_paypal":"Payment Gateway Paypal","invalid_setting":"Invalid Setting","merchantkey":"Merchantkey","payu_salt":"Payu Salt","payu_merchantkey":"Payu Merchantkey","payu_workingkey":"Payu Workingkey","payu_mode":"Payu Mode","enter_value":"Enter Value","discount_maximum_amount":"Discount Maximum Amount","id_paid":"Id Paid","exams_are_in_use_for_this_category":"Exams Are In Use For This Category","no_records_available":"No Records Available","invalid_subject":"Invalid Subject","demo_subject__have_no_topics,_please_add_topics_to_upload_questions":"Demo Subject  Have No Topics, Please Add Topics To Upload Questions","start_exam":"Start Exam","please_accept_terms_and_conditions":"Please Accept Terms And Conditions","please_read_the_instructions_carefully":"Please Read The Instructions Carefully","general_instructions":"General Instructions","site_coupons":"Site Coupons","select_your_child":"Select Your Child","already_in_use":"Already In Use","please_add_children_to_continue_payment":"Please Add Children To Continue Payment","topper_percentage":"Topper Percentage","update_strings":"Update Strings","home":"Home","faqs":"Faqs","about_us":"About Us","contact_us":"Contact Us","admin_dashboard":"Admin Dashboard","overall_users":"Overall Users","roles":"Roles","fee_settings":"Fee Settings","fee_categories":"Fee Categories","fee_category_allotment":"Fee Category Allotment","fee_particulars":"Fee Particulars","fee_schedules":"Fee Schedules","fines":"Fines","discounts":"Discounts","religions_master":"Religions Master","academics_master":"Academics Master","courses_master":"Courses Master","course_subjects":"Course Subjects","library":"Library","asset_types":"Asset Types","master_data":"Master Data","publishers":"Publishers","authors":"Authors","students":"Students","staff":"Staff","school_hub":"School Hub","attendance":"Attendance","update_details":"Update Details","tool_tip":"Tool Tip","test":"Test","paypaltool":"Paypaltool","pavanvalue":"Pavanvalue","offline_payment":"Offline Payment","click_here_to_update_payment_details":"Click Here To Update Payment Details","offline_payment_form":"Offline Payment Form","offline_payment_information":"Offline Payment Information","offline_payment_instructions":"Offline Payment Instructions","payment_details":"Payment Details","submit":"Submit","your_request_was_submitted_to_admin_with_reference_5a41d36fb3a6fdc49fc1818f0e2bf6d42694dbf8":"Your Request Was Submitted To Admin With Reference 5a41d36fb3a6fdc49fc1818f0e2bf6d42694dbf8","your_request_was_submitted_to_admin_with_reference_a0ed34accbd54955a7990a3b86de1702990c0d46":"Your Request Was Submitted To Admin With Reference A0ed34accbd54955a7990a3b86de1702990c0d46","your_request_was_submitted_to_admin":"Your Request Was Submitted To Admin","logged_out_successfully":"Logged Out Successfully","view_profile":"View Profile","user_roles":"User Roles","permissions":"Permissions","add_role":"Add Role","role_name":"Role Name","display_name":"Display Name","list_roles":"List Roles","religions":"Religions","this_field_id_required":"This Field Id Required","account_settings":"Account Settings","no_categories_available":"No Categories Available","click_here_to_change_your_preferences":"Click Here To Change Your Preferences","no_series_available":"No Series Available","module_payu":"Module Payu","messaging":"Messaging","push_notifications":"Push Notifications","pusher_app_id":"Pusher App Id","pusher_key":"Pusher Key","pusher_secret":"Pusher Secret","one_signal_app_id":"One Signal App Id","one_signal_subdomain_name":"One Signal Subdomain Name","default":"Default","driver":"Driver","logo":"Logo","left_sign_image":"Left Sign Image","right_sign_image":"Right Sign Image","left_sign_name":"Left Sign Name","right_sign_name":"Right Sign Name","left_sign_designation":"Left Sign Designation","right_sign_designation":"Right Sign Designation","watermark_image":"Watermark Image","bottom_middle_logo":"Bottom Middle Logo","generate_certificate":"Generate Certificate","certificate_generation":"Certificate Generation","certificate":"Certificate","certificate_for":"Certificate For","print":"Print","payment_statistics":"Payment Statistics","cancelled":"Cancelled","pending":"Pending","payment_monthly_statistics":"Payment Monthly Statistics","payments_reports_in":"Payments Reports In","overall_statistics":"Overall Statistics","demanding_quizzes":"Demanding Quizzes","quizzes_usage":"Quizzes Usage","demanding":"Demanding","paid_quizzes_usage":"Paid Quizzes Usage","overall":"Overall","payment_reports":"Payment Reports","online_payments":"Online Payments","offline_payments":"Offline Payments","payments":"Payments","success_list":"Success List","user_name":"User Name","item":"Item","plan":"Plan","payment_gateway":"Payment Gateway","payment_status":"Payment Status","export":"Export","export_payments_report":"Export Payments Report","all_records":"All Records","from":"From","to":"To","payment_type":"Payment Type","all":"All","online":"Online","offline":"Offline","download_excel":"Download Excel","from_date":"From Date","to_date":"To Date","export_payment_records":"Export Payment Records","offline_payment_details":"Offline Payment Details","notes":"Notes","created_at":"Created At","approve":"Approve","reject":"Reject","close":"Close","comments":"Comments","record_was_updated_successfully":"Record Was Updated Successfully","send_sms":"Send Sms","sms_to":"Sms To","parents":"Parents","admins":"Admins","for_category":"For Category","selected":"Selected","message_template":"Message Template","messges_sent_successfully_for_25_users":"Messges Sent Successfully For 25 Users","messges_sent_successfully_for_0_users":"Messges Sent Successfully For 0 Users","messges_sent_successfully_for_1_users":"Messges Sent Successfully For 1 Users","no_users_available_with_the_combination":"No Users Available With The Combination","info":"Info","sms":"Sms","this_record_is_in_use_in_other_modules":"This Record Is In Use In Other Modules","show_foreign_key_constraint":"Show Foreign Key Constraint","duration":"Duration","examseries":"Examseries","minimum_bill_not_reached__this_is_valid_for_minimum_purchase_of_$_111_00":"Minimum Bill Not Reached. This Is Valid For Minimum Purchase Of $ 111.00","hey_student":"Hey Student","are_you_sure":"Are You Sure","you_will_not_be_able_to_recover_this_record":"You Will Not Be Able To Recover This Record","delete_it":"Delete It","cancel_please":"Cancel Please","your_record_has_been_deleted":"Your Record Has Been Deleted","your_record_is_safe":"Your Record Is Safe","enter_maximum_amount":"Enter Maximum Amount","enter_usage_limit_per_user":"Enter Usage Limit Per User","please_enter_10-15_digit_mobile_number":"Please Enter 10-15 Digit Mobile Number","please_enter_your_address":"Please Enter Your Address","upload_excel":"Upload Excel","easy":"Easy","medium":"Medium","hard":"Hard","fill_in_the_blanks":"Fill In The Blanks","video":"Video","saved_questions":"Saved Questions","introduction":"Introduction","description_of_the_topic":"Description Of The Topic","after_discount":"After Discount","hey_rajesh":"Hey Rajesh","file_type_not_allowed":"File Type Not Allowed","enter_category_name":"Enter Category Name","oops___!":"Oops...!","improper_sheet_uploaded":"Improper Sheet Uploaded","congrats you are the new top 10 scorer of this exam":"Congrats You Are The New Top 10 Scorer Of This Exam","click on toper to compare your score":"Click On Toper To Compare Your Score","it will be updated by adding the exams":"It Will Be Updated By Adding The Exams","it will be updated by adding the questions":"It Will Be Updated By Adding The Questions","topic (id)":"Topic (id)","ooops...!":"Ooops...!","page not found":"Page Not Found","exam_duration":"Exam Duration","hints":"Hints","quiz_and_exam_series":"Quiz And Exam Series","time_limit":"Time Limit","time_taken":"Time Taken","bookmarks":"Bookmarks","email content":"Email Content","ooops..!":"Ooops..!","no records available":"No Records Available","reset_password":"Reset Password","reset_link_sent":"Reset Link Sent","oops..!":"Oops..!","invalid_email":"Invalid Email","password_reset_link_sent_to_email":"Password Reset Link Sent To Email","cannot_change_password":"Cannot Change Password","update_lms":"Update Lms","enter_minimum_bill":"Enter Minimum Bill","time":"Time","time_is_shown_in_seconds":"Time Is Shown In Seconds","mail_driver":"Mail Driver","mail_host":"Mail Host","mail_port":"Mail Port","mail_username":"Mail Username","mail_password":"Mail Password","mail_encryption":"Mail Encryption","payu_merchant_key":"Payu Merchant Key","payu_working_key":"Payu Working Key","payu_test_mode":"Payu Test Mode","payu_testmode":"Payu Testmode","one_signal_user_id":"One Signal User Id","messaging_system_for":"Messaging System For","facebook_login":"Facebook Login","google_plus_login":"Google Plus Login","record_added_successfully_with_password ":"Record Added Successfully With Password "}', '2016-08-30 00:41:02', '2016-10-19 19:26:39');

-- --------------------------------------------------------

--
-- Table structure for table `lmscategories`
--

CREATE TABLE `lmscategories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `record_updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lmscontents`
--

CREATE TABLE `lmscontents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `content_type` enum('file','video','audio','url','video_url','audio_url','iframe') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'file',
  `is_url` tinyint(1) NOT NULL DEFAULT '0',
  `file_path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `record_updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lmsseries`
--

CREATE TABLE `lmsseries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_paid` tinyint(4) NOT NULL DEFAULT '0',
  `cost` decimal(10,2) NOT NULL,
  `validity` int(11) NOT NULL,
  `total_items` int(11) NOT NULL,
  `lms_category_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `short_description` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `record_updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lmsseries_data`
--

CREATE TABLE `lmsseries_data` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lmsseries_id` bigint(20) UNSIGNED NOT NULL,
  `lmscontent_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `thread_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messenger_participants`
--

CREATE TABLE `messenger_participants` (
  `id` int(10) UNSIGNED NOT NULL,
  `thread_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `last_read` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messenger_threads`
--

CREATE TABLE `messenger_threads` (
  `id` int(10) UNSIGNED NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1),
('2016_06_03_064954_create_categories_table', 1),
('2016_06_03_065219_create_groups_table', 1),
('2016_06_03_065542_create_religions_table', 1),
('2016_06_03_124331_entrust_setup_tables', 1),
('2016_06_04_103906_create_staff_table', 1),
('2016_06_04_120754_create_departments_table', 1),
('2016_06_08_051533_create_subjects_table', 2),
('2016_06_08_055114_create_topics_table', 3),
('2016_06_08_060004_create_grades_table', 4),
('2016_06_08_061136_create_courses_table', 5),
('2016_06_08_061850_create_semisters_table', 5),
('2016_06_08_062918_create_academics_table', 6),
('2016_06_08_063211_create_academic_courses_table', 7),
('2016_06_08_084952_create_course_subject_table', 8),
('2016_06_08_105532_create_students_table', 9),
('2016_06_11_063359_create_feecategories_table', 10),
('2016_06_11_084226_create_feecategories_academiccours_table', 11),
('2016_06_11_133218_create_feeparticulars_table', 12),
('2016_06_13_053203_create_feeschedules_table', 13),
('2016_06_13_054213_create_feeschedules_academiccourses_table', 13),
('2016_06_15_173616_create_coursesemisters_table', 14),
('2016_06_21_071054_create_fines_table', 15),
('2016_06_21_081251_create_feediscounts_table', 16),
('2016_06_23_054631_create_questionbank_table', 17),
('2016_06_24_164447_create_libraryassettypes_table', 18),
('2016_06_25_010303_create_librarymasters_table', 19),
('2016_06_25_025855_create_authors_table', 20),
('2016_06_25_025920_create_publishers_table', 20),
('2016_06_25_142623_create_libraryassetinstances_table', 21),
('2016_06_28_052506_create_quizcategories_table', 22),
('2016_06_28_071010_create_quizzes_table', 23),
('2016_06_28_100819_create_questionbank_quizzes_table', 24),
('2016_07_02_010553_create_libraryissues_table', 24),
('2016_07_06_014807_create_lmscategories_table', 25),
('2016_07_06_033653_create_lmscontents_table', 26),
('2016_07_08_025939_create_subscriptions_table', 27),
('2014_10_28_175635_create_threads_table', 28),
('2014_10_28_175710_create_messages_table', 28),
('2014_10_28_180224_create_participants_table', 28),
('2014_11_03_154831_add_soft_deletes_to_participants_table', 28),
('2014_11_10_083449_add_nullable_to_last_read_in_participants_table', 28),
('2014_11_20_131739_alter_last_read_in_participants_table', 28),
('2014_12_04_124531_add_softdeletes_to_threads_table', 28),
('2016_07_18_091544_create_quizresults_table', 29),
('2016_07_19_102858_create_emailtemplates_table', 30),
('2016_07_20_042956_create_activity_log_table', 31),
('2016_07_27_091354_create_studentpromotions_table', 32),
('2016_07_27_120013_create_studentattendance_table', 33),
('2016_08_02_073034_create_packages_table', 34),
('2016_08_29_043256_create_settings_table', 35),
('2016_09_02_095405_create_instructions_table', 36),
('2016_09_05_091459_create_bookmarks_table', 37),
('2016_09_05_094520_create_examseries_table', 38),
('2016_09_07_105933_create_examseries_data_table', 39),
('2016_09_08_101822_create_payments_table', 40),
('2016_09_13_104746_create_couponcodes_table', 41),
('2016_09_16_160343_create_lmsseries_table', 42),
('2016_09_17_052834_create_notifications_table', 43),
('2016_09_21_105036_create_examtoppers_table', 44),
('2016_09_26_154438_create_feedbacks_table', 45),
('2016_10_13_120753_create_certifacates_table', 46);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `short_description` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `valid_from` date NOT NULL,
  `valid_to` date NOT NULL,
  `record_updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(10) UNSIGNED NOT NULL,
  `slug` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `plan_type` enum('combo','lms','exam','other') COLLATE utf8_unicode_ci NOT NULL,
  `payment_gateway` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `transaction_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `paid_by_parent` tinyint(1) NOT NULL DEFAULT '0',
  `paid_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `coupon_applied` tinyint(4) NOT NULL DEFAULT '0',
  `coupon_id` int(11) NOT NULL,
  `actual_cost` decimal(10,2) NOT NULL,
  `discount_amount` decimal(10,2) NOT NULL,
  `after_discount` decimal(10,2) NOT NULL,
  `paid_amount` decimal(10,2) NOT NULL,
  `payment_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `other_details` text COLLATE utf8_unicode_ci NOT NULL,
  `transaction_record` text COLLATE utf8_unicode_ci,
  `notes` text COLLATE utf8_unicode_ci NOT NULL,
  `admin_comments` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questionbank`
--

CREATE TABLE `questionbank` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `topic_id` bigint(20) UNSIGNED NOT NULL,
  `question_tags` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `question_type` enum('radio','checkbox','descriptive','blanks','match','para','video','audio') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'radio',
  `question` text COLLATE utf8_unicode_ci NOT NULL,
  `question_file` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `question_file_is_url` tinyint(1) NOT NULL DEFAULT '0',
  `total_answers` int(10) UNSIGNED NOT NULL,
  `answers` text COLLATE utf8_unicode_ci NOT NULL,
  `total_correct_answers` int(50) NOT NULL DEFAULT '1',
  `correct_answers` text COLLATE utf8_unicode_ci NOT NULL,
  `marks` int(10) UNSIGNED NOT NULL,
  `time_to_spend` int(11) NOT NULL DEFAULT '1',
  `difficulty_level` enum('easy','medium','hard') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'easy',
  `hint` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `explanation` text COLLATE utf8_unicode_ci NOT NULL,
  `explanation_file` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questionbank_quizzes`
--

CREATE TABLE `questionbank_quizzes` (
  `id` int(10) UNSIGNED NOT NULL,
  `questionbank_id` bigint(20) UNSIGNED NOT NULL,
  `quize_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `marks` int(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quizcategories`
--

CREATE TABLE `quizcategories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `record_updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quizresults`
--

CREATE TABLE `quizresults` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `quiz_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `marks_obtained` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `negative_marks` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total_marks` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `percentage` decimal(10,2) NOT NULL,
  `exam_status` enum('pass','fail','pending') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending',
  `answers` text COLLATE utf8_unicode_ci NOT NULL,
  `subject_analysis` text COLLATE utf8_unicode_ci,
  `correct_answer_questions` text COLLATE utf8_unicode_ci,
  `wrong_answer_questions` text COLLATE utf8_unicode_ci,
  `not_answered_questions` text COLLATE utf8_unicode_ci,
  `time_spent_correct_answer_questions` text COLLATE utf8_unicode_ci NOT NULL,
  `time_spent_wrong_answer_questions` text COLLATE utf8_unicode_ci NOT NULL,
  `time_spent_not_answered_questions` text COLLATE utf8_unicode_ci NOT NULL,
  `percentage_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `grade_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `grade_points` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `rank` int(11) DEFAULT NULL,
  `total_users_for_this_quiz` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dueration` int(11) NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `is_paid` tinyint(4) NOT NULL DEFAULT '0',
  `cost` decimal(10,2) DEFAULT NULL,
  `validity` int(11) NOT NULL,
  `total_marks` decimal(10,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `having_negative_mark` tinyint(1) NOT NULL DEFAULT '0',
  `negative_mark` decimal(10,2) NOT NULL DEFAULT '0.00',
  `pass_percentage` decimal(10,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `tags` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `publish_results_immediately` tinyint(4) NOT NULL DEFAULT '1',
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `total_questions` int(50) NOT NULL,
  `instructions_page_id` bigint(20) UNSIGNED NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `record_updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'owner', 'Owner', 'Owner of this account', '2016-06-08 03:32:59', '2016-06-08 03:32:59'),
(2, 'admin', 'Admin', 'Admin of this Account', '2016-06-08 03:33:19', '2016-06-08 03:33:19'),
(5, 'student', 'Student', 'Student User', '2016-06-08 04:01:54', '2016-06-08 04:01:54'),
(6, 'parent', 'Parent User', 'Parent Login', '2016-06-08 07:35:27', '2016-06-08 07:35:27');

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `settings_data` text COLLATE utf8_unicode_ci,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `title`, `key`, `slug`, `image`, `settings_data`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Email Settings', 'email_settings', 'email-settings', NULL, '{"mail_driver":{"value":"smtp","type":"select","extra":{"total_options":"8","options":{"smtp":"SMTP","mail":"Mail","sparkpost":"Sparkpost","sendmail":"Sendmail","mailgun":"Mailgun","mandrill":"Mandrill","ses":"SES","log":"Log"}},"tool_tip":"Driver"},"mail_host":{"value":"mail.yourserver.com","type":"text","extra":{"total_options":"8","options":{"smtp":"SMTP","mail":"Mail","sparkpost":"Sparkpost","sendmail":"Sendmail","mailgun":"Mailgun","mandrill":"Mandrill","ses":"SES","log":"Log"}},"tool_tip":"Mail Host"},"mail_port":{"value":"2525","type":"text","extra":{"total_options":"8","options":{"smtp":"SMTP","mail":"Mail","sparkpost":"Sparkpost","sendmail":"Sendmail","mailgun":"Mailgun","mandrill":"Mandrill","ses":"SES","log":"Log"}},"tool_tip":"Mail Port no"},"mail_username":{"value":"yourid@yourserver.com","type":"text","extra":{"total_options":"8","options":{"smtp":"SMTP","mail":"Mail","sparkpost":"Sparkpost","sendmail":"Sendmail","mailgun":"Mailgun","mandrill":"Mandrill","ses":"SES","log":"Log"}},"tool_tip":"Mail Username"},"mail_password":{"value":"yourpassword","type":"password","extra":{"total_options":"8","options":{"smtp":"SMTP","mail":"Mail","sparkpost":"Sparkpost","sendmail":"Sendmail","mailgun":"Mailgun","mandrill":"Mandrill","ses":"SES","log":"Log"}},"tool_tip":"Password"},"mail_encryption":{"value":"null","type":"text","extra":{"total_options":"8","options":{"smtp":"SMTP","mail":"Mail","sparkpost":"Sparkpost","sendmail":"Sendmail","mailgun":"Mailgun","mandrill":"Mandrill","ses":"SES","log":"Log"}},"tool_tip":"Mail Encryption"}}', 'Contains all the settings related to emails', '2016-08-28 23:55:26', '2016-11-24 05:56:27'),
(4, 'Paypal Settings', 'paypal', 'paypal', 'Zw7qp7b7lc2yCvM.png', '{"email":{"value":"youremail","type":"email","extra":"","tool_tip":"Paypal Email"},"currency":{"value":"USD","type":"text","extra":"","tool_tip":"Default Currency"},"image":{"value":"fCStst6ekDhWzfL.png","type":"file","extra":"","tool_tip":"Image to display at Paypal payment gateway"},"account_type":{"value":"sandbox","type":"select","extra":{"total_options":"2","options":{"sandbox":"Sandbox","live":"Live"}},"tool_tip":"Account Type Development (sandbox)\\/ Production (live)"}}', 'Contains paypal config details', '2016-09-08 03:38:30', '2016-11-24 05:57:10'),
(5, 'PayU Settings', 'payu', 'payu', NULL, '{"payu_merchant_key":{"value":"yourkey","type":"text","extra":"","tool_tip":"PayU Merchent Key"},"payu_salt":{"value":"yoursalt","type":"text","extra":"","tool_tip":"PayU Salt"},"payu_working_key":{"value":"yourworkingkey","type":"text","extra":"","tool_tip":"PayU Working Key"},"payu_testmode":{"value":"true","type":"select","extra":{"total_options":"2","options":{"true":"Yes","false":"No"}},"tool_tip":"Set PayU in Test Mode"}}', 'Payu Settings', '2016-09-09 01:25:33', '2016-11-24 05:55:46'),
(6, 'Site Settings', 'site_settings', 'site-settings', NULL, '{"site_title":{"value":"Menorah OES","type":"text","extra":"","tool_tip":"Site Title"},"site_logo":{"value":"rSGKGfhIQ45U9QW.png","type":"file","extra":"","tool_tip":"Site Logo"},"site_address":{"value":"8929 Fremont Court \\r\\nMchenry, \\r\\nIL 60050","type":"textarea","extra":"","tool_tip":"Address"},"site_city":{"value":"Hyderabad","type":"text","extra":"","tool_tip":"City"},"site_favicon":{"value":"Wg9dSY7az6WgXpO.png","type":"file","extra":"","tool_tip":"Favicon"},"site_state":{"value":"Telangana","type":"text","extra":"","tool_tip":"State"},"site_country":{"value":"India","type":"text","extra":"","tool_tip":"Country"},"site_zipcode":{"value":"500018","type":"text","extra":"","tool_tip":"Postal Code"},"site_phone":{"value":"1234567891","type":"text","extra":"","tool_tip":"Phone"},"system_timezone":{"value":"Asia\\/Kolkata","type":"text","extra":"","tool_tip":"Refer http:\\/\\/php.net\\/manual\\/en\\/timezones.php"},"phone_number_expression":{"value":"\\/^\\\\d{10}$\\/","type":"text","extra":"","tool_tip":"Give regular expression for your phone no."},"background_image":{"value":"Pe6AvaMsX3niANH.jpeg","type":"file","extra":"","tool_tip":"Background image at front end before login"},"currency_code":{"value":"$","type":"text","extra":"","tool_tip":"Add Currency Code"}}
', 'Here you can manage the title, logo, favicon and all general settings', '2016-09-29 06:46:54', '2017-01-24 05:00:51'),
(7, 'Seo Settings', 'seo_settings', 'seo-settings-1', NULL, '{"meta_description":{"value":"Menorah Online Examination System","type":"textarea","extra":"","tool_tip":"Site Meta Description"},"meta_keywords":{"value":"Menorah Online Examination System","type":"textarea","extra":"","tool_tip":"Site Meta Keywords"},"google_analytics":{"value":"<!-- Google Analytics -->\\r\\n<script>\\r\\n(function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){\\r\\n(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),\\r\\nm=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)\\r\\n})(window,document,\'script\',\'https:\\/\\/www.google-analytics.com\\/analytics.js\',\'ga\');\\r\\n\\r\\nga(\'create\', \'UA-XXXXX-Y\', \'auto\');\\r\\nga(\'send\', \'pageview\');\\r\\n<\\/script>\\r\\n<!-- End Google Analytics -->","type":"textarea","extra":"","tool_tip":"Update your google analytics code"}}', 'Contains all SEO settings', '2016-09-30 13:33:46', '2016-11-24 05:53:39'),
(8, 'Payment Gateways', 'payment_gateways', 'payment-gateways', NULL, '{"offline_payment_information":{"value":"1) Pay the amount through DD\\/Check\\/Deposit in favor of Admin, Academia, India <br\\/>\\r\\n2) Update the Payment information in the below box <br\\/>\\r\\n3) Admin will validate the payment details and update your subscription <br\\/>","type":"textarea","extra":"","tool_tip":"Information related to offline payment"}}', 'Contains all list of payment gateways in the system and the status of availability ', '2016-10-02 09:48:19', '2017-01-23 11:17:28'),
(9, 'Modules Management', 'module', 'module', NULL, '{"payu":{"value":"1","type":"checkbox","extra":"","tool_tip":"Enable\\/Disable PayU Payment Gateway"},"paypal":{"value":"1","type":"checkbox","extra":"","tool_tip":"Enable\\/Disable Paypal Payment Gateway"},"messaging":{"value":"1","type":"checkbox","extra":"","tool_tip":"Enable\\/Disable Messaging Module"},"parent":{"value":"1","type":"checkbox","extra":"","tool_tip":"Enable\\/Disable Parent Module"},"coupons":{"value":"1","type":"checkbox","extra":"","tool_tip":"Enable\\/Disable Coupons Module"},"offline_payment":{"value":"1","type":"checkbox","extra":"","tool_tip":"Enable\\/Disable Offline Payment Option"},"certificate":{"value":"1","type":"checkbox","extra":"","tool_tip":"Enable\\/Disable Certificate Module"},"show_foreign_key_constraint":{"value":0,"type":"checkbox","extra":"","tool_tip":"sho foreign key constraint message at delete operation"},"facebook_login":{"value":"1","type":"checkbox","extra":"","tool_tip":"Enable\\/Disable Facebook Login"},"google_plus_login":{"value":"1","type":"checkbox","extra":"","tool_tip":"Enable\\/Disable Google+ Login"}}', 'You can enable or disable modules in the system', '2016-10-12 11:36:22', '2016-11-23 09:31:43'),
(11, 'Certificate', 'certificate', 'certificate', NULL, '{"logo":{"value":"BHJ3ILUWVH4uPH9.png","type":"file","extra":"","tool_tip":"Header logo of certificate"},"content":{"value":"<span style=\\"font-size:18px; font-style:italic;\\">This is to certify that <b style=\\"padding:0 10px; font-size:22px;\\">{{$username}}<\\/b> Lorem Ipsum is simply dummy text <b style=\\"padding:0 10px; font-size:22px;\\">{{$course_name}}<\\/b> of the printing with score of <b style=\\"padding:0 10px; font-size:22px;\\">{{$marks}}<\\/b> and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took<\\/span>","type":"textarea","extra":"","tool_tip":"Content for the certificate"},"left_sign_image":{"value":"5Ci7Olem7IgiGnv.png","type":"file","extra":"","tool_tip":"Left Sign Image"},"right_sign_image":{"value":"5ANb26yLV5pNSfc.png","type":"file","extra":"","tool_tip":"Right Sign Image"},"left_sign_name":{"value":"Kiran","type":"text","extra":"","tool_tip":"Left Sign Name"},"right_sign_name":{"value":"Kumar","type":"text","extra":"","tool_tip":"Right Sign Name"},"left_sign_designation":{"value":"Course Teacher","type":"text","extra":"","tool_tip":"Left Sign Designation"},"right_sign_designation":{"value":"Admin","type":"text","extra":"","tool_tip":"Right Sign Designation"},"watermark_image":{"value":"Lotdj6RBOtuf5Y4.png","type":"file","extra":"","tool_tip":"Water Mark Image for transparent background"},"bottom_middle_logo":{"value":"RY8Vk1iWBjkQ9Yb.png","type":"file","extra":"","tool_tip":"Bottom middle logo"}}', 'This Module contains the settings for Certificate', '2016-10-13 06:57:36', '2016-11-24 05:47:39'),
(12, 'Social Logins', 'social_logins', 'social-logins', NULL, '{"facebook_client_id":{"value":"YourID","type":"text","extra":"","tool_tip":"Facebook Client ID"},"facebook_client_secret":{"value":"YourSecret","type":"text","extra":"","tool_tip":"Facebook Client Secret"},"facebook_redirect_url":{"value":"http:\\/\\/yoursite.com\\/auth\\/facebook\\/callback","type":"text","extra":"","tool_tip":"It should be http (or) https:\\/\\/yourservername\\/auth\\/google\\/callback"},"google_client_id":{"value":"yourid.apps.googleusercontent.com","type":"text","extra":"","tool_tip":"Google Plus Client ID"},"Google_client_secret":{"value":"yoursecret","type":"text","extra":"","tool_tip":"Google Client Secret Key"},"google_redirect_url":{"value":"http:\\/\\/yoursite.com\\/auth\\/google\\/callback","type":"text","extra":"","tool_tip":"http (or) https:\\/\\/yourserver.com\\/auth\\/google\\/callback"}}', 'Add/Update Settings for Social Logins (Facebook and Google plus)', '2016-10-28 10:56:37', '2016-11-24 05:51:49'),
(13, 'Messaging System', 'messaging_system', 'messaging-system', NULL, '{"messaging_system_for":{"value":"all","type":"select","extra":{"total_options":"2","options":{"all":"All","admin":"Admin and Student"}},"tool_tip":"To whome you want to use this system"}}', '', '2016-10-29 16:33:37', '2016-10-31 13:41:19'),
(14, 'SMS Settings', 'sms_settings', 'sms-settings', NULL, '{"sms_driver":{"value":"nexmo","type":"select","extra":{"total_options":"3","options":{"nexmo":"NEXMO","plivo":"PLIVO","twilio":"TWILIO"}},"tool_tip":"Select SMS driver"},"nexmo_key":{"value":"NEXMO_KEY","type":"text","extra":{"total_options":"3","options":{"nexmo":"NEXMO","plivo":"PLIVO","twilio":"TWILIO"}},"tool_tip":"Nexmo API Key"},"nexmo_secret":{"value":"NEXMO_SECRET","type":"text","extra":{"total_options":"3","options":{"nexmo":"NEXMO","plivo":"PLIVO","twilio":"TWILIO"}},"tool_tip":"Enter Nexmo Secret Key"},"plivo_auth_id":{"value":"PLIVO_AUTH_ID","type":"text","extra":{"total_options":"3","options":{"nexmo":"NEXMO","plivo":"PLIVO","twilio":"TWILIO"}},"tool_tip":"Enter Plivo Auth ID"},"plivo_auth_token":{"value":"PLIVO_AUTH_TOKEN","type":"text","extra":{"total_options":"3","options":{"nexmo":"NEXMO","plivo":"PLIVO","twilio":"TWILIO"}},"tool_tip":"Plivo Auth Token"},"twilio_sid":{"type":"text","value":"TWILIO_SID","extra":"","tool_tip":"Twilio SID"},"twilio_token":{"type":"text","value":"TWILIO_TOKEN","extra":"","tool_tip":"Twilio Token"}}', 'Contains settings for SMS', '2017-01-25 05:10:09', '2017-01-25 05:30:16');

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subject_title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `subject_code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `maximum_marks` int(11) NOT NULL,
  `pass_marks` int(11) NOT NULL,
  `is_lab` tinyint(4) NOT NULL DEFAULT '0',
  `is_elective_type` tinyint(4) NOT NULL DEFAULT '0',
  `status` enum('Active','Inactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `stripe_id` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `stripe_plan` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) NOT NULL DEFAULT '0',
  `topic_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `login_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `role_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `stripe_active` tinyint(1) NOT NULL DEFAULT '0',
  `stripe_id` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `stripe_plan` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `paypal_email` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `card_brand` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `card_last_four` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `subscription_ends_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `settings` text COLLATE utf8_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `couponcodes`
--
ALTER TABLE `couponcodes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `couponcodes_usage`
--
ALTER TABLE `couponcodes_usage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `coupon_id` (`coupon_id`);

--
-- Indexes for table `emailtemplates`
--
ALTER TABLE `emailtemplates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `examseries`
--
ALTER TABLE `examseries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `examseries_data`
--
ALTER TABLE `examseries_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `examseries_id` (`examseries_id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `examtoppers`
--
ALTER TABLE `examtoppers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `quiz_id` (`quiz_id`),
  ADD KEY `quiz_result_id` (`quiz_result_id`),
  ADD KEY `quiz_id_2` (`quiz_id`),
  ADD KEY `quiz_result_id_2` (`quiz_result_id`);

--
-- Indexes for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `groups_group_unique` (`group`);

--
-- Indexes for table `instructions`
--
ALTER TABLE `instructions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `lmscategories`
--
ALTER TABLE `lmscategories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lmscategories_slug_unique` (`slug`);

--
-- Indexes for table `lmscontents`
--
ALTER TABLE `lmscontents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lmscontents_slug_unique` (`slug`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `lmsseries`
--
ALTER TABLE `lmsseries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lms_category_id` (`lms_category_id`);

--
-- Indexes for table `lmsseries_data`
--
ALTER TABLE `lmsseries_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lmsseries_id` (`lmsseries_id`),
  ADD KEY `lmscontent_id` (`lmscontent_id`);

--
-- Indexes for table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messenger_participants`
--
ALTER TABLE `messenger_participants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messenger_threads`
--
ALTER TABLE `messenger_threads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`);

--
-- Indexes for table `questionbank`
--
ALTER TABLE `questionbank`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `topic_id` (`topic_id`);

--
-- Indexes for table `questionbank_quizzes`
--
ALTER TABLE `questionbank_quizzes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `questionbank_quizzes_questionbank_id_foreign` (`questionbank_id`),
  ADD KEY `quize_id` (`quize_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `quizcategories`
--
ALTER TABLE `quizcategories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `quizcategories_slug_unique` (`slug`);

--
-- Indexes for table `quizresults`
--
ALTER TABLE `quizresults`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `quizzes_slug_unique` (`slug`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `instructions_page_id` (`instructions_page_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `role_user_role_id_foreign` (`role_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`),
  ADD UNIQUE KEY `settings_slug_unique` (`slug`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `bookmarks`
--
ALTER TABLE `bookmarks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `couponcodes`
--
ALTER TABLE `couponcodes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `couponcodes_usage`
--
ALTER TABLE `couponcodes_usage`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `emailtemplates`
--
ALTER TABLE `emailtemplates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `examseries`
--
ALTER TABLE `examseries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `examseries_data`
--
ALTER TABLE `examseries_data`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `examtoppers`
--
ALTER TABLE `examtoppers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `instructions`
--
ALTER TABLE `instructions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `lmscategories`
--
ALTER TABLE `lmscategories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `lmscontents`
--
ALTER TABLE `lmscontents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `lmsseries`
--
ALTER TABLE `lmsseries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `lmsseries_data`
--
ALTER TABLE `lmsseries_data`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `messenger_participants`
--
ALTER TABLE `messenger_participants`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `messenger_threads`
--
ALTER TABLE `messenger_threads`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `questionbank`
--
ALTER TABLE `questionbank`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5762;
--
-- AUTO_INCREMENT for table `questionbank_quizzes`
--
ALTER TABLE `questionbank_quizzes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;
--
-- AUTO_INCREMENT for table `quizcategories`
--
ALTER TABLE `quizcategories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `quizresults`
--
ALTER TABLE `quizresults`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21754;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD CONSTRAINT `bookmarks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bookmarks_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `questionbank` (`id`);

--
-- Constraints for table `couponcodes_usage`
--
ALTER TABLE `couponcodes_usage`
  ADD CONSTRAINT `couponcodes_usage_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `couponcodes_usage_ibfk_2` FOREIGN KEY (`coupon_id`) REFERENCES `couponcodes` (`id`);

--
-- Constraints for table `examseries`
--
ALTER TABLE `examseries`
  ADD CONSTRAINT `examseries_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `quizcategories` (`id`);

--
-- Constraints for table `examseries_data`
--
ALTER TABLE `examseries_data`
  ADD CONSTRAINT `examseries_data_ibfk_1` FOREIGN KEY (`examseries_id`) REFERENCES `examseries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `examseries_data_ibfk_2` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`);

--
-- Constraints for table `examtoppers`
--
ALTER TABLE `examtoppers`
  ADD CONSTRAINT `examtoppers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `examtoppers_ibfk_2` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`),
  ADD CONSTRAINT `examtoppers_ibfk_3` FOREIGN KEY (`quiz_result_id`) REFERENCES `quizresults` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD CONSTRAINT `feedbacks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lmscontents`
--
ALTER TABLE `lmscontents`
  ADD CONSTRAINT `lmscontents_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`);

--
-- Constraints for table `lmsseries`
--
ALTER TABLE `lmsseries`
  ADD CONSTRAINT `lmsseries_ibfk_1` FOREIGN KEY (`lms_category_id`) REFERENCES `lmscategories` (`id`);

--
-- Constraints for table `lmsseries_data`
--
ALTER TABLE `lmsseries_data`
  ADD CONSTRAINT `lmsseries_data_ibfk_1` FOREIGN KEY (`lmsseries_id`) REFERENCES `lmsseries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lmsseries_data_ibfk_2` FOREIGN KEY (`lmscontent_id`) REFERENCES `lmscontents` (`id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `questionbank`
--
ALTER TABLE `questionbank`
  ADD CONSTRAINT `questionbank_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`),
  ADD CONSTRAINT `questionbank_ibfk_2` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`);

--
-- Constraints for table `questionbank_quizzes`
--
ALTER TABLE `questionbank_quizzes`
  ADD CONSTRAINT `questionbank_quizzes_ibfk_1` FOREIGN KEY (`questionbank_id`) REFERENCES `questionbank` (`id`),
  ADD CONSTRAINT `questionbank_quizzes_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`),
  ADD CONSTRAINT `questionbank_quizzes_ibfk_3` FOREIGN KEY (`quize_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `quizresults`
--
ALTER TABLE `quizresults`
  ADD CONSTRAINT `quizresults_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`),
  ADD CONSTRAINT `quizresults_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD CONSTRAINT `quizzes_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `quizcategories` (`id`),
  ADD CONSTRAINT `quizzes_ibfk_2` FOREIGN KEY (`instructions_page_id`) REFERENCES `instructions` (`id`);

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `topics`
--
ALTER TABLE `topics`
  ADD CONSTRAINT `topics_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
