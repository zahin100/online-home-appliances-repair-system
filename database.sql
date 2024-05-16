
--
-- Database: `student_b032010175`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customerID` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phoneNumber` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customerID`, `name`, `email`, `phoneNumber`, `address`, `username`, `password`) VALUES
(1001, 'Muhammad Haikal', 'haikal@example.com', '0123456789', 'Selangor', 'haikal', '$2y$10$rM3Jz7dZvQVKZOAEbkH9Z.7PwHzjLm6r0A9emUkf6mTpCcNItSqkC'),
(1002, 'Siti Aliya', 'siti@example.com', '0123456789', 'Perak', 'aliya', '$2y$10$YTxgnfjrsqWq.Cs8ZybpdeqnwQpj.TJ5FqnGa9o5nZuA7c2xakMLS'),
(1003, 'Abdillah Yusuf', 'abdillah@example.com', '0123456789', 'Terengganu', 'abdillah', '$2y$10$Ah/npuET3jIXItYuEfb/RO4nXIhkTGfzDy36A1G2JZChYv7hZ1oQq'),
(1004, 'Danial Fitri', 'danial@example.com', '0123456789', 'Kedah', 'danial', '$2y$10$zbGaWFQKUsGJobgqZdWdTuqcgrSrrDdDPnvmLARhqDRT5w/XlQ.zW'),
(1005, 'Nur Emilia', 'emilia@example.com', '0123456789', 'Johor', 'emilia', '$2y$10$O610zRjFe6xqLxHGfsL7z.F4.wp./a.rX1V9J53YjOR6ivS34yghq'),
(1006, 'Maisarah', 'aa@gmail.com', '0123456789', 'Kuala Terengganu', 'maisarah', '$2y$10$rprwpCf6scz4aayjw9yiH.MeQVT7lf1zqi8zVHGqevwaBImrSVbbW'),
(1007, 'test', 'test@gmail.com', '0123456789', 'test,Melaka', 'test123', '$2y$10$Tw.PGfg15E6VhDsK8zmfpuw60NAOvC8WSyv5VFA32KXr0J9QrBJUy'),
(1008, 'a', 'a@a.com', '0123456789', 'a', 'aaaaa', '$2y$10$8SvU/9pBcOp2.FKQXjPzteR4ArpvJQ5bxM52q4uSx06FasvJQTb52');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedbackID` int(11) NOT NULL,
  `customerID` int(11) NOT NULL,
  `star` varchar(10) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedbackID`, `customerID`, `star`, `description`) VALUES
(1, 1001, '4', 'Great service!'),
(2, 1002, '5', 'Excellent experience!'),
(3, 1003, '3', 'Average feedback.'),
(4, 1004, '2', 'Needs improvement.'),
(5, 1005, '5', 'Highly recommended!');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `inventoryID` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`inventoryID`, `name`, `image`, `price`, `quantity`) VALUES
(17, 'Transistor', 'transistor.jpg', '20.00', 120),
(18, 'Resistor', 'resistor.jpg', '25.00', 97),
(19, 'Transceiver', 'transceiver.jpg', '83.00', 55),
(20, 'LED', 'led.jpg', '5.00', 130),
(21, 'Fuse', 'fuse.jpg', '30.00', 200),
(22, 'Diode', 'diode.jpg', '15.00', 129),
(23, 'Capacitor', 'capacitor.jpg', '17.00', 100);

-- --------------------------------------------------------

--
-- Table structure for table `repairrequest`
--

CREATE TABLE `repairrequest` (
  `repairRequestID` int(11) NOT NULL,
  `customerID` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `image` varchar(100) NOT NULL,
  `type` varchar(50) NOT NULL,
  `brand` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL,
  `repairStatus` varchar(50) DEFAULT NULL,
  `deliveryStatus` varchar(50) DEFAULT NULL,
  `totalPrice` decimal(10,2) DEFAULT 0.00,
  `paymentStatus` varchar(50) DEFAULT NULL,
  `paymentFile` varchar(100) DEFAULT NULL,
  `shippingAddress` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `repairrequest`
--

INSERT INTO `repairrequest` (`repairRequestID`, `customerID`, `date`, `image`, `type`, `brand`, `description`, `repairStatus`, `deliveryStatus`, `totalPrice`, `paymentStatus`, `paymentFile`, `shippingAddress`) VALUES
(1, 1001, '2023-07-03', 'fan.jpg', 'Fan', 'Samsung', 'Unable to turn on the appliance.', 'Completed', 'Shipped', '270.00', 'Completed', 'receipt.png', 'Melaka'),
(2, 1002, '2023-07-04', 'iron.jpg', 'Iron', 'LG', 'Unable to turn on the appliance.', 'Completed', 'Shipped', '120.00', 'Completed', 'receipt.png', 'Melaka'),
(3, 1003, '2023-07-05', 'kettle.jpg', 'Kettle', 'Panasonic', 'Unable to turn on the appliance.', 'Completed', 'Shipped', '70.00', 'Completed', 'receipt.png', 'Melaka'),
(4, 1004, '2023-07-06', 'ricecooker.png', 'Rice Cooker', 'Samsung', 'Unable to turn on the appliance.', 'Completed', 'Shipped', '90.00', 'Completed', 'receipt.png', 'Melaka'),
(5, 1005, '2023-07-07', 'fan.jpg', 'Fan', 'LG', 'Unable to turn on the appliance.', 'Completed', 'Shipped', '130.00', 'Completed', 'receipt.png', 'Melaka'),
(6, 1001, '2023-07-08', 'iron.jpg', 'Iron', 'Panasonic', 'Unable to turn on the appliance.', 'Completed', 'Shipped', '160.00', 'Completed', 'receipt.png', 'Melaka'),
(7, 1002, '2023-07-12', 'kettle.jpg', 'Kettle', 'Samsung', 'Unable to turn on the appliance.', 'Completed', 'Shipped', '60.00', 'Completed', 'receipt.png', 'Melaka'),
(8, 1003, '2023-07-17', 'ricecooker.png', 'Rice Cooker', 'LG', 'Unable to turn on the appliance.', 'Completed', 'Shipped', '70.00', 'Completed', 'receipt.png', 'Melaka'),
(9, 1004, '2023-01-03', 'fan.jpg', 'Fan', 'Panasonic', 'Unable to turn on the appliance.', 'Completed', 'Shipped', '145.00', 'Completed', 'receipt.png', 'Melaka'),
(10, 1005, '2023-02-03', 'iron.jpg', 'Iron', 'Samsung', 'Unable to turn on the appliance.', 'Completed', 'Shipped', '132.00', 'Completed', 'receipt.png', 'Melaka'),
(11, 1006, '2023-03-03', 'kettle.jpg', 'Kettle', 'LG', 'Unable to turn on the appliance.', 'Completed', 'Shipped', '147.00', 'Completed', 'receipt.png', 'Melaka'),
(12, 1001, '2023-04-03', 'ricecooker.png', 'Rice Cooker', 'Panasonic', 'Unable to turn on the appliance.', 'Completed', 'Shipped', '77.00', 'Completed', 'receipt.png', 'Melaka'),
(13, 1006, '2023-05-03', 'fan.jpg', 'Fan', 'Samsung', 'Unable to turn on the appliance.', 'Completed', 'Shipped', '81.00', 'Completed', 'receipt.png', 'Melaka'),
(14, 1006, '2023-06-03', 'iron.jpg', 'Iron', 'LG', 'Unable to turn on the appliance.', 'Completed', 'Shipped', '87.00', 'Completed', 'receipt.png', 'Melaka'),
(15, 1002, '2023-02-03', 'kettle.jpg', 'Kettle', 'Panasonic', 'Unable to turn on the appliance.', 'Completed', 'Shipped', '120.00', 'Completed', 'receipt.png', 'Melaka'),
(16, 1006, '2023-05-03', 'ricecooker.png', 'Rice Cooker', 'Samsung', 'Unable to turn on the appliance.', 'Completed', 'Shipped', '200.00', 'Completed', 'receipt.png', 'Melaka'),
(17, 1003, '2023-07-30', 'fan.jpg', 'Fan', 'LG', 'Unable to turn on the appliance.', 'Pending', 'Pending', '0.00', 'Pending', NULL, 'Melaka'),
(18, 1006, '2023-07-30', 'iron.jpg', 'Iron', 'Panasonic', 'Unable to turn on the appliance.', 'Pending', 'Pending', '0.00', 'Pending', NULL, 'Melaka'),
(19, 1006, '2023-07-25', 'fan.jpg', 'Fan', 'Samsung', 'Unable to turn on the appliance.', 'Completed', 'Pending', '74.00', 'Completed', 'receipt.png', 'Kuala Terengganu'),
(20, 1001, '2023-07-08', 'kettle.jpg', 'Kettle', 'LG', 'Unable to turn on the appliance.', 'Completed', 'Pending', '70.00', 'Pending', NULL, 'Melaka'),
(21, 1007, '2023-07-10', '2164a23be001a4c.png', 'Fan', 'LG', 'The fan is broken', 'Pending', 'Pending', '0.00', 'Pending', NULL, NULL),
(22, 1008, '2024-05-02', '22blender-575445_1280.png', 'Other', 'Samsung', 'a', 'Completed', 'Pending', '138.00', 'Completed', '22Blank Page.pdf', 'a');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staffID` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phoneNumber` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staffID`, `name`, `phoneNumber`, `username`, `password`) VALUES
(2, 'Azmi', '1234567890', 'azmi', '$2y$10$dm6fynrSrwWtw/H9QQWX6.AKlz2upY4j04S8LtTU.vR7wlYV61n36'),
(3, 'Nurul', '1234567890', 'nurul', '$2y$10$5W3Iyy7R0EUbk1PxrdTvv.n0NfcrY.5lTsDYfYYf5RlYVCNcGn4tK');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customerID`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedbackID`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`inventoryID`);

--
-- Indexes for table `repairrequest`
--
ALTER TABLE `repairrequest`
  ADD PRIMARY KEY (`repairRequestID`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staffID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1009;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedbackID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `inventoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `repairrequest`
--
ALTER TABLE `repairrequest`
  MODIFY `repairRequestID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staffID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;