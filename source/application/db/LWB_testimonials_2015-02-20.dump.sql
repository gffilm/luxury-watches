----
-- phpLiteAdmin database dump (http://phpliteadmin.googlecode.com)
-- phpLiteAdmin version: 1.9.5
-- Exported: 11:26am on February 20, 2015 (UTC)
-- database file: .\LWB.sq3
----
BEGIN TRANSACTION;

----
-- Table structure for testimonials
----
CREATE TABLE [testimonials] ([watch_id] INTEGER PRIMARY KEY, [member_id] TEXT, [auction_date] TEXT, [auction_info] TEXT, [auction_number] TEXT, [member_comments] TEXT, [sold_for_amount] TEXT, [approved] INTEGER DEFAULT(0));

----
-- Data dump for testimonials, a total of 11 rows
----
INSERT INTO "testimonials" ("watch_id","member_id","auction_date","auction_info","auction_number","member_comments","sold_for_amount","approved") VALUES ('1','e_wilkes','July 9, 2010','MENS ORIS FRANK SINATRA CHRONOGRAPH WATCH 67675744061','350343249010','Very nice transaction. Fast shipping. Caring and conscientious eBayer. A+++','1,350.00','1');
INSERT INTO "testimonials" ("watch_id","member_id","auction_date","auction_info","auction_number","member_comments","sold_for_amount","approved") VALUES ('4','','07/07/2010','TAG HEUER 2000 DIGITAL MULTIGRAPH WATCH WK111A.BA0331','350318542395','Excellent ebayer, very very fast service and shipping. Recommended A++++++++++++','820','1');
INSERT INTO "testimonials" ("watch_id","member_id","auction_date","auction_info","auction_number","member_comments","sold_for_amount","approved") VALUES ('5','ma-ma-mahonie','07/05/2010','MENS ANONIMO OPERA MECCANA FIRENZE DUAL TIME GMT WATCH','350369237876','Fantastic operator! AAA++ Fast postage to Australia!','2995','1');
INSERT INTO "testimonials" ("watch_id","member_id","auction_date","auction_info","auction_number","member_comments","sold_for_amount","approved") VALUES ('6','junoparis','07/30/2010','MENS OMEGA SEAMASTER DIVER 300M AUTOMATIC WATCH 2254.50','260621684890','Beautiful! Maybe nicer than it looked online! Very well packed, arrived fast!','1625','1');
INSERT INTO "testimonials" ("watch_id","member_id","auction_date","auction_info","auction_number","member_comments","sold_for_amount","approved") VALUES ('7','clancysmother','06/24/2010','VINTAGE TIFFANY & CO 18K YELLOW GOLD LOVE KNOT NECKLACE','350364930549','Item as described. Beautiful. Received order quickly. Seller helpful.','1325','1');
INSERT INTO "testimonials" ("watch_id","member_id","auction_date","auction_info","auction_number","member_comments","sold_for_amount","approved") VALUES ('8','Boris Kheyfets','03/06/2014','Rolex Submariner','Website','Beautiful Watch Excellent Deal! Thank you!','1600','0');
INSERT INTO "testimonials" ("watch_id","member_id","auction_date","auction_info","auction_number","member_comments","sold_for_amount","approved") VALUES ('9','Jim S. - Atlanta, Ga.','03/13/2014','Rolex Submarimer','Website','Very professional!  Great communicator and a pleasure to deal with.  Tops on my list for honesty and value.  Thanks!','','1');
INSERT INTO "testimonials" ("watch_id","member_id","auction_date","auction_info","auction_number","member_comments","sold_for_amount","approved") VALUES ('10','Zack F','03/31/2014','Panerai ','Website','Watch is beautiful.  Very professional.  Will do business with again!','','1');
INSERT INTO "testimonials" ("watch_id","member_id","auction_date","auction_info","auction_number","member_comments","sold_for_amount","approved") VALUES ('11','Elena','08/01/2014','Mens Omega Speedmaster Professional Apollo 11 Chronograph Limited Edition Panda Dial Watch 3569.   
','Website','It was an absolute pleasure doing business! Amazing communicator, watch is beautiful in excellent condition and delivered to Canada overnight! Seller very professional and would recommend him to anyone!  Thank-you!! ','','1');
INSERT INTO "testimonials" ("watch_id","member_id","auction_date","auction_info","auction_number","member_comments","sold_for_amount","approved") VALUES ('12','Rob K','08/02/2014','I purchased two watches, a Panerai 241 in mint condition, and an Omega Seamaster. Fantastic transactions and quality watches, excellent customer service, and super fast shipping. I highly recommend and will be a repeat customer. ','Website','','7850','1');
INSERT INTO "testimonials" ("watch_id","member_id","auction_date","auction_info","auction_number","member_comments","sold_for_amount","approved") VALUES ('13','Stephen Waldman','02/15/2014','Rolex submariner 2008','Website','','5380.00','1');
COMMIT;
