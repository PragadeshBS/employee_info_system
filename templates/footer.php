<script>
	const toggleButton = document.getElementsByClassName('toggle-btn')[0];
	const navbarLinks = document.getElementsByClassName('navbar-links')[0];
	const infoText = document.getElementsByClassName('info');
	if (infoText.length > 0)
	{
		const mainInfoText = infoText[0];
		if (!mainInfoText.textContent.trim()){
			mainInfoText.style.display = 'none';
		}
	}
	toggleButton.addEventListener('click', () => {
	navbarLinks.classList.toggle('active');
	})
</script>
</body>
</html>