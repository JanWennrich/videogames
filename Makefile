build-page:
	$(MAKE) clean
	mkdir build
	php generate-html.php > build/index.html
	cp -r assets/* build/
clean:
	rm -rf build