<?php

	# Utility class for writing to files
	class FileWriter {

		# Name of file to output
		private $path;

		# Files handle
		private $fileHandle;

		# Content on file
		private $fileContent;

		# Create a new FileWriter
		#
		# $path     => The files name & location
		# $method   => The method of writing, w+ by default
		public function __construct($path, $method = 'w+') {
			$this->path = $path;
			$this->fileHandle = fopen($this->path, $method);
		}

		# Add a line to the file with a newline
		#
		# $line     => The line to add to the file
		public function addLine($line, $prefix = null) {
			$this->fileContent[] = ($prefix != null ? $prefix : "") . $line . "\n";
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
			chmod($this->path, 0777);
		}

	}

?>