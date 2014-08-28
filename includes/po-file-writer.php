<?php

	# Utility class for writing to files
	class FileWriter {

		# Name of file to output
		private $fileName;

		# Files handle
		private $fileHandle;

		# Content on file
		private $fileContent;

		# Create a new FileWriter
		#
		# $fileName => The files name
		# $method   => The method of writing, w+ by default
		public function __construct($fileName, $method = 'w+') {
			$this->fileName = $fileName;
			$this->fileHandle = fopen($this->fileName, $method);
		}

		# Add a line to the file with a newline
		#
		# $line     => The line to add to the file
		public function addLine($line) {
			$this->fileContent[] = $line . "\n";
		}

		# Add an empty line to the file
		public function emptyLine() {
			$this->fileContent[] = "\n";
		}

		# Write the file and close resources
		public function writeFile() {
			foreach ($this->fileContent as $line) {
				fwrite($this->fileHandle, $line);
			}
			fclose($this->fileHandle);
		}

	}

?>