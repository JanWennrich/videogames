build-page:
	$(MAKE) clean
	mkdir build
	php generate-html.php > build/index.html
	cp -r resources/* build/
clean:
	rm -rf build