--
-- Table structure for table `tblproduct`
--

CREATE TABLE `tblproduct` (
  `id` int(8) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `price` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblproduct`
--

INSERT INTO `tblproduct` (`id`, `name`, `code`, `image`, `price`) VALUES
(1, 'HOODIE BLACK', 'HBLACK1', 'productimages/hoodie/image0.jpg', 100.00),
(2, 'SWEATER BLACK', 'SBLACK1', 'productimages/hoodie/image1.jpg', 100.00),
(3, 'SWEATER BLUE', 'SBLUE1', 'productimages/hoodie/image2.jpg', 100.00),
(4, 'SWEATER BLUE', 'SBLUE2', 'productimages/hoodie/image3.jpg', 100.00),
(5, 'SWEATER RED', 'SRED1', 'productimages/hoodie/image4.jpg', 100.00),
(6, 'HOODIE RED', 'HRED1', 'productimages/hoodie/image5.jpg', 100.00),
(8, 'SWEATER WHITE', 'SWHITE1', 'productimages/hoodie/image6.jpg', 100.00),
(9, 'SWEATER WHITE', 'SWHITE2', 'productimages/hoodie/image7.jpg', 100.00),
(10, 'JACKET WHITE', 'JWHITE1', 'productimages/jackets/image0.jpg', 100.00),
(11, 'JACKET GRAY', 'JGRAY1', 'productimages/jackets/image1.jpg', 100.00),
(12, 'JACKET BLACK', 'JBLACK1', 'productimages/jackets/image2.jpg', 100.00),
(13, 'JACKET BLUE', 'JBLUE1', 'productimages/jackets/image3.jpg', 100.00),
(14, 'JACKET BLACK', 'JBLACK2', 'productimages/jackets/image4.jpg', 100.00),
(15, 'JACKET BROWN', 'JBROWN1', 'productimages/jackets/image5.jpg', 100.00),
(16, 'JACKET RED', 'JRED1', 'productimages/jackets/image6.jpg', 100.00),
(18, 'SNEAKERS WHITE', 'SNWHITE1', 'productimages/sneakers/image0.jpg', 100.00),
(19, 'SNEAKERS BLACK', 'SNBLACK1', 'productimages/sneakers/image1.jpg', 100.00),
(20, 'SNEAKERS GREEN', 'SNGREEN1', 'productimages/sneakers/image2.jpg', 100.00),
(21, 'SNEAKERS WHITE', 'SNWHITE2', 'productimages/sneakers/image3.jpg', 100.00),
(22, 'SNEAKERS WHITE', 'SNWHITE3', 'productimages/sneakers/image4.jpg', 100.00),
(23, 'SNEAKERS WHITE', 'SNWHITE4', 'productimages/sneakers/image5.jpg', 100.00),
(24, 'SNEAKERS WHITE', 'SNWHITE5', 'productimages/sneakers/image6.jpg', 100.00);

--
-- Indexes for table `tblproduct`
--
ALTER TABLE `tblproduct`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_code` (`code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblproduct`
--
ALTER TABLE `tblproduct`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;